<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Configure;
use App\Models\Order;
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

    public function cps()
    {
        
    }
}
