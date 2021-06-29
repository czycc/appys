<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\FlowOutRequest;
use App\Models\Flow;
use App\Models\FlowOut;
use App\Models\UserExtra;
use App\Transformers\FlowOutTransformer;
use App\Transformers\FlowTransformer;
use Illuminate\Http\Request;

class FlowController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     *
     * 当前用户流水列表
     */
    public function index()
    {
        $flows = Flow::select(['id', 'title', 'total_amount', 'created_at'])
            ->where('user_id', $this->user()->id)
            ->where('total_amount', '>', 0)
            ->orderByDesc('id')
            ->paginate(20);

        return $this->response
            ->paginator($flows, new FlowTransformer())
            ->addMeta('balance', $this->user()->balance)
            ->addMeta('bound_extra', (boolean)$this->user()->extra);
    }

    /**
     * @return mixed
     *
     * 当前用户提现列表
     */
    public function flowOutList()
    {
        $outs = FlowOut::select(['id', 'total_amount', 'created_at', 'status', 'out_status'])
            ->where('user_id', $this->user()->id)
            ->orderByDesc('id')
            ->paginate(20);

        return $this->response->paginator($outs, new FlowOutTransformer());
    }

    /**
     * @param FlowOutRequest $request
     * @param FlowOut $flowOut
     * @return mixed
     *
     * 提交提现
     */
    public function flowOutStore(FlowOutRequest $request, FlowOut $flowOut)
    {
        if ($request->out_method == 'alipay') {
//            return $this->response->errorBadRequest('支付宝提现将于近期开放，敬请期待');
            $out_info = [
                'out_biz_no' => time(),
                'trans_amount' => $request->total_amount,
                'product_code' => 'TRANS_ACCOUNT_NO_PWD',
                'payee_info' => [
                    'identity' => $request->ali_account,
                    'identity_type' => 'ALIPAY_LOGON_ID'
                ]
            ];
        }else {
            return $this->response->errorBadRequest('微信提现暂时关闭，敬请期待');
            //微信提现
            if (!$this->user()->wap_openid) {
                return $this->response->errorBadRequest('受微信官方限制，首次微信提现请先前往网页端');
            }
            $out_info = [
                'partner_trade_no' => uniqid(),
                'openid' => $this->user()->wap_openid,
                'amount' => $request->total_amount * 100,
                'desc' => '用户余额微信提现',
                "check_name" => "NO_CHECK",
                ];
        }
        if (!$this->user()->extra) {
            $extra = new UserExtra();

            $extra->name = $request->name;
            $extra->idcard = $request->idcard;
            $extra->health = $request->health;
            $extra->extra = $request->extra;
            $extra->user_id = $this->user()->id;
            $extra->save();
        }

        $flowOut->total_amount = $request->total_amount;
        $flowOut->out_method = $request->out_method;

        $flowOut->user_id = $this->user()->id;
        $flowOut->status = 0;
        $flowOut->out_status = 0;

        //提现字段信息
        $flowOut->out_info = $out_info;
        $flowOut->save();
        return $this->response->array(['data' => $flowOut])->setStatusCode(201);
    }
}
