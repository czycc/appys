<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Configure;
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
            ->first();

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

        return Pay::alipay()->success();
    }

    public function cps(Order $order, User $user)
    {
        //根据订单用户分成
        switch ($type = $order->type) {
            //购买用户文章
            case 'article':

                break;
            //购买vip
            case 'vip':

                //一级分成虚拟币，自己购买会员得银币,三级分销
                $configure = Configure::first();
                $user->silver += $configure->buy_vip2_self;
                $user->save();

                if ($user->bound_id) {
                    //上级是代理得金币，是银牌得银币
                    $top = User::find($user);
                    if ($top->vip === 1) {
                        $top->silver += $configure->buy_vip2_top_vip2;
                    } elseif ($top->vip === 2) {
                        //代理
                        $top->gold += $configure->buy_vip2_top_vip3;
                    }

                    $top->save();
                }

                //会员购买三级分销

                break;
            case 'course':

                break;
        }
    }
}
