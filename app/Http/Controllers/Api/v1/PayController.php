<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\Chapter;
use App\Models\Configure;
use App\Models\Course;
use App\Models\Flow;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NormalNotify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    /**
     * @return mixed
     *
     * 返回铜币使用最大比例和1元兑换铜币数量
     */
    public function copper()
    {
        $configure = Configure::select(['copper_pay_percent', 'copper_pay_num'])
            ->first()->toArray();

        $configure['user_copper'] = $this->user()->copper;
        return $this->response->array(['data' => $configure]);
    }

    /**
     * @return mixed
     * 阿里回调通知
     */
    public function alipayNotify()
    {
        $data = Pay::alipay()->verify();

        //如果订单状态不是成功或结束，不走后续逻辑
        if (!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            return Pay::alipay()->success();
        }

        $order = Order::where('no', $data->out_trade_no)->first();

        //查询不到订单
        if (!$order) {
            return 'fail';
        }

        //已经支付
        if ($order->paid_at) {
            return Pay::alipay()->success();
        }

        //订单已经关闭
        if ($order->closed) {
            return 'fail';
        }

        $order->update([
            'paid_at' => Carbon::now(),
            'pay_method' => 'alipay',
            'pay_no' => $data->trade_no
        ]);

        $this->cps($order, $order->user);

        return Pay::alipay()->success();
    }

    /**
     * @return string
     *
     * 微信支付回调通知
     */
    public function wechatNotify()
    {
        $data = Pay::wechat()->verify();

        $order = Order::where('no', $data->out_trade_no)->first();

        //查询不到订单
        if (!$order) {
            return 'fail';
        }

        //已经支付
        if ($order->paid_at) {
            return Pay::wechat()->success();
        }

        //订单已经关闭
        if ($order->closed) {
            return 'fail';
        }

        $order->update([
            'paid_at' => Carbon::now(),
            'pay_method' => 'wechat',
            'pay_no' => $data->transaction_id
        ]);

        $this->cps($order, $order->user);

        return Pay::wechat()->success();

    }

    /**
     * @param Order $order
     * @param User $user
     *
     * 分销&支付后相关逻辑处理
     */
    public function cps(Order $order, User $user)
    {
        $configure = Configure::first();
        //根据订单用户分成
        switch ($type = $order->type) {
            //购买用户文章
            case 'audio':
            case 'video':
            case 'topic':
                $article = Article::find($order->type_id);
                Flow::create([
                    'title' => '作品被购买收益',
                    'user_id' => $article->user_id,
                    'order_id' => $order->id,
                    'total_amount' => big_num($order->total_amount)
                        ->multiply($configure['pub_self'] / 100)
                        ->getValue(),
                    'extra' => $article->type,
                ]);
                //发送通知
                $article->user->msgNotify(new NormalNotify(
                    '作品被购买',
                    "{$article->title}被{$user->nickname}购买",
                    'normal',
                    $article->id
                ));

                break;
            //购买vip
            case 'vip':

                //一级分成虚拟币，自己购买会员得银币,三级分销
                $user->silver += $configure->buy_vip2_self;
                //更新会员
                $user->vip = 1;
                if ($user->expire_at < Carbon::now()) {
                    $user->expire_at = Carbon::now()->addYear();
                } else {
                    $user->expire_at = $user->expire_at->addYear();
                }
                $user->save();

                if ($user->bound_id) {

                    //上级是代理得金币，是银牌得银币
                    $top = User::find($user->bound_id);
                    if ($top->vip === '银牌会员') {
                        $top->silver += $configure->buy_vip2_top_vip2;
                    } elseif ($top->vip === '代理会员') {
                        //代理
                        $top->gold += $configure->buy_vip2_top_vip3;
                    }
                    $top->save();

                    //会员购买三级分销
                    Flow::create([
                        'title' => '邀请会员购买银牌收益',
                        'user_id' => $top->id,
                        'order_id' => $order->id,
                        'total_amount' => big_num($order->total_amount)
                            ->multiply($configure->distribute1_vip / 100)
                            ->getValue(),
                        'extra' => '会员一级分销',
                    ]);

                    if ($top->bound_id) {
                        $top2 = User::find($top->bound_id);
                        Flow::create([
                            'title' => '邀请会员购买银牌收益',
                            'user_id' => $top2->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute2_vip / 100)
                                ->getValue(),
                            'extra' => '会员二级分销'
                        ]);
                        if ($top2->bound_id) {
                            $top3 = User::find($top2->bound_id);
                            Flow::create([
                                'title' => '邀请会员购买银牌收益',
                                'user_id' => $top3->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute3_vip / 100)
                                    ->getValue(),
                                'extra' => '会员三级级分销'
                            ]);
                        }
                    }
                }

                break;
            case 'course':
            case 'chapter':

                //提高课程购买数
                if ($type == 'course') {
                    Course::where('id', $order->type_id)->increment('buy_count', 1);
                } else {
                    Course::where('id', Chapter::find($order->type_id)->course_id)->increment('buy_count', 1);
                }

                //购买课程或章节， 三级分销
                if ($user->bound_id) {
                    $top = User::find($user->bound_id);
                    //收益
                    Flow::create([
                        'title' => '邀请会员购买课程收益',
                        'user_id' => $top->id,
                        'order_id' => $order->id,
                        'total_amount' => big_num($order->total_amount)
                            ->multiply($configure->distribute1_course / 100)
                            ->getValue(),
                        'extra' => '课程一级分销',
                    ]);
                    if ($top->bound_id) {
                        $top2 = User::find($top->bound_id);
                        //收益
                        Flow::create([
                            'title' => '邀请会员购买课程收益',
                            'user_id' => $top2->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute2_course / 100)
                                ->getValue(),
                            'extra' => '课程二级分销',
                        ]);

                        if ($top->bound_id) {
                            $top3 = User::find($top2->bound_id);
                            //收益
                            Flow::create([
                                'title' => '邀请会员购买课程收益',
                                'user_id' => $top3->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute3_course / 100)
                                    ->getValue(),
                                'extra' => '课程三级分销',
                            ]);
                        }
                    }
                }
                break;
        }
    }

}
