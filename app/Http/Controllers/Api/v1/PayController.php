<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\Configure;
use App\Models\Flow;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        //已经支付
        if ($order->paid_at) {
            return Pay::alipay()->success();
        }

        $order->update([
            'paid_at' => Carbon::now(),
            'pay_method' => 'alipay',
            'pay_no' => $data->trade_no
        ]);

        $this->cps($order, $order->user_id);

        return Pay::alipay()->success();
    }

    public function cps(Order $order, User $user)
    {
        $configure = Configure::first();
        //根据订单用户分成
        switch ($type = $order->type) {
            //购买用户文章
            case 'article':
                $article = Article::find($order->type_id);
                Flow::create([
                    'title' => '作品被购买收益',
                    'user_id' => $article->user_id,
                    'order_id' => $order->id,
                    'total_amount' => big_num($order->total_amount)
                        ->multiply($configure['pub_self'] / 100),
                    'extra' => $article->type,
                ]);
                break;
            //购买vip
            case 'vip':

                //一级分成虚拟币，自己购买会员得银币,三级分销
                $user->silver += $configure->buy_vip2_self;
                $user->save();

                if ($user->bound_id) {

                    //上级是代理得金币，是银牌得银币
                    $top = User::find($user->bound_id);
                    if ($top->vip === 1) {
                        $top->silver += $configure->buy_vip2_top_vip2;
                    } elseif ($top->vip === 2) {
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
                            ->multiply($configure->distribute1_vip / 100),
                        'extra' => '会员一级分销',
                    ]);

                    if ($top->bound_id) {
                        $top2 = User::find($top->bound_id);
                        Flow::create([
                            'title' => '邀请会员购买银牌收益',
                            'user_id' => $top2->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute2_vip / 100),
                            'extra' => '会员二级分销'
                        ]);
                        if ($top2->bound_id) {
                            $top3 = User::find($top2->bound_id);
                            Flow::create([
                                'title' => '邀请会员购买银牌收益',
                                'user_id' => $top3->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute3_vip / 100),
                                'extra' => '会员三级级分销'
                            ]);
                        }
                    }
                }


                break;
            case 'course':
            case 'chapter':
                //购买课程或章节， 三级分销
                if ($user->bound_id) {
                    $top = User::find($user->bound_id);
                    //收益
                    Flow::create([
                        'title' => '邀请会员购买课程收益',
                        'user_id' => $top->id,
                        'order_id' => $order->id,
                        'total_amount' => big_num($order->total_amount)
                            ->multiply($configure->distribute1_course / 100),
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
                                ->multiply($configure->distribute2_course / 100),
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
                                    ->multiply($configure->distribute3_course / 100),
                                'extra' => '课程三级分销',
                            ]);
                        }
                    }
                }
                break;
        }
    }

}
