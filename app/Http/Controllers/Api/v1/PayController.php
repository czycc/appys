<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\ApplePayOrder;
use App\Models\Article;
use App\Models\Chapter;
use App\Models\Configure;
use App\Models\Course;
use App\Models\Flow;
use App\Models\Order;
use App\Models\User;
use App\Models\UserCoin;
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
        $configure['coin'] = $this->user()->coin();
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
                if ($article->media_type == 'audio') {
                    $titleType = '音频购买';
                } elseif ($article->media_type == 'video') {
                    $titleType = '小视频';
                } elseif ($article->media_type == 'topic') {
                    $titleType = '文章';
                } else {
                    $titleType = '作品';
                }
                Flow::create([
                    'title' => $titleType . '收益',
                    'user_id' => $article->user_id,
                    'order_id' => $order->id,
                    'total_amount' => big_num($order->total_amount)
                        ->multiply($configure['pub_self'] / 100)
                        ->getValue(),
                    'extra' => $article->media_type,
                ]);
                //发送通知
                $article->user->msgNotify(new NormalNotify(
                    '作品被购买',
                    "您的作品 {$article->title} 被 {$user->nickname} 购买",
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

                if ($user->bound_status) {

                    //上级是代理得金币，是银牌得银币
                    $top = User::find($user->bound_id);
                    if ($top->vip === '银牌会员') {
                        $top->silver += $configure->buy_vip2_top_vip2;
                    } elseif ($top->vip === '代理会员') {
                        //代理
                        $top->gold += $configure->buy_vip2_top_vip3;
                    }
                    $top->save();

                    if ($top->vip !== '铜牌会员') {
                        //会员购买三级分销
                        Flow::create([
                            'title' => '会员邀请收益',
                            'user_id' => $top->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute1_vip / 100)
                                ->getValue(),
                            'extra' => '会员一级分销',
                        ]);
                    }


                    if ($top->bound_status) {
                        $top2 = User::find($top->bound_id);
                        if ($top2->vip !== '铜牌会员') {
                            Flow::create([
                                'title' => '会员邀请收益',
                                'user_id' => $top2->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute2_vip / 100)
                                    ->getValue(),
                                'extra' => '会员二级分销'
                            ]);
                        }
                        if ($top2->bound_status) {
                            $top3 = User::find($top2->bound_id);

                            if ($top3->vip !== '铜牌会员') {
                                Flow::create([
                                    'title' => '会员邀请收益',
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
                if ($user->bound_status) {
                    $top = User::find($user->bound_id);
                    if ($top->vip !== '铜牌会员') {
                        //收益
                        Flow::create([
                            'title' => '课程购买收益',
                            'user_id' => $top->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute1_course / 100)
                                ->getValue(),
                            'extra' => '课程一级分销',
                        ]);
                    }
                    if ($top->bound_status) {
                        $top2 = User::find($top->bound_id);

                        if ($top2->vip !== '铜牌会员') {
                            //收益
                            Flow::create([
                                'title' => '课程购买收益',
                                'user_id' => $top2->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute2_course / 100)
                                    ->getValue(),
                                'extra' => '课程二级分销',
                            ]);
                        }

                        if ($top->bound_status) {
                            $top3 = User::find($top2->bound_id);

                            if ($top3->vip !== '铜牌会员') {
                                //收益
                                Flow::create([
                                    'title' => '课程购买收益',
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
                }
                break;
        }
    }

    /**
     * @param Request $request
     *
     * 虚拟币充值
     */
    public function iosPayCoin(Request $request)
    {
        $this->validate($request, [
            'receipt' => 'required|string'
        ], [], [
            'receipt' => '支付票据'
        ]);

        $data = $this->acurl($request->input('receipt'), false);
        if (!is_array($data) && !isset($data['status'])) {
            return $this->response->error('获取苹果服务器支付数据失败', 408);
        }
        // 判断是否购买成功
        if ($data['status'] === 0) {
            $ios = config('pay.ios');
            if (array_key_exists($product_id = $data['receipt']['in_app'][0]['product_id'], $ios)) {
                //判断是否已经记录
                if (ApplePayOrder::where('transaction_id', $data['receipt']['in_app'][0]['transaction_id'])->first()) {
                    return $this->response->array([
                        'data' => [
                            'coin' => $this->user()->coin()
                        ]
                    ]);
                }
                $ord = new ApplePayOrder();
                $ord->coin = $ios[$product_id];
                $ord->transaction_id = $data['receipt']['in_app'][0]['transaction_id'];
                $ord->extra = $data;
                $ord->user_id = $this->user()->id;
                $ord->save();
                //增加当前用户虚拟币
                if ($userCoin = $this->user()->userCoin()->first()) {
                    $userCoin->coin += $ios[$product_id];
                    $userCoin->save();
                } else {
                    $userCoin = new UserCoin();
                    $userCoin->user_id = $this->user()->id;
                    $userCoin->coin = $ios[$product_id];
                    $userCoin->save();
                }
                return $this->response->array([
                    'data' => [
                        'coin' => $userCoin->coin
                    ]
                ]);
            } else {
                return $this->response->errorBadRequest('不存在的充值金额');
            }
        } elseif ($data['status'] === 21007) {
            //用于测试审核
            return $this->response->array([
                'data' => [
                    'coin' => $this->user()->coin()
                ]
            ]);
        } else {
            return $this->response->errorBadRequest($data['status']);
        }
    }

    /**
     * @param $receipt_data
     * @param bool $sandbox
     * @return bool|string
     *
     * 请求票据
     */
    protected function acurl($receipt_data, $sandbox = false)
    {
        //小票信息
        $POSTFIELDS = array("receipt-data" => $receipt_data);
        $POSTFIELDS = json_encode($POSTFIELDS);
        //正式购买地址 沙盒购买地址
        $url_buy = "https://buy.itunes.apple.com/verifyReceipt";
        $url_sandbox = "https://sandbox.itunes.apple.com/verifyReceipt";
        $url = $sandbox ? $url_sandbox : $url_buy;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, '6');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_HEADER, 0);
        curl_setopt($curl_handle, CURLOPT_POST, true);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $POSTFIELDS);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl_handle);
        curl_close($curl_handle);

        $result = json_decode($result, true);
        if ($result['status'] == 21007) {
            //测试地址
            $url = $url_sandbox;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_TIMEOUT, '6');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_HEADER, 0);
            curl_setopt($curl_handle, CURLOPT_POST, true);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $POSTFIELDS);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl_handle);
            curl_close($curl_handle);
            $result = json_decode($result, true);

        }
        return $result;
    }
}
