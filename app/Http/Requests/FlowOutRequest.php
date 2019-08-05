<?php

namespace App\Http\Requests;


class FlowOutRequest extends Request
{

    public function rules()
    {
        $rules =  [
            'total_amount' => 'required|numeric|max:' . \Auth::guard('api')->user()->balance,
            'out_method' => 'required|in:alipay,wechat',
        ];

        //支付宝填写账号
        if ($this->out_method == 'alipay') {
            $rules['ali_account'] = 'required|string';
        }
        //微信需要绑定用户
        if ($this->out_method == 'wechat' && !\Auth::guard('api')->user()->wx_openid) {
            $rules['bound_wechat'] = 'required';
        }

        //首次提现填写信息
        if (!\Auth::guard('api')->user()->extra) {
            $rules['name'] = 'required|string';
            $rules['idcard'] = 'required|string';
            $rules['health'] = 'required|string';
            $rules['extra'] = 'string';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'total_amount.required' => '提现金额不能为空',
            'total_amount.max' => '提现金额不能超过当前收益余额',
            'name.required' => '首次提现需完善用户信息-姓名',
            'idcard.required' => '首次提现需完善用户信息-身份证号',
            'health.required' => '首次提现需完善用户信息-健康状态',
            'bound_wechat.required' => '微信需要绑定账号'
        ];
    }
}
