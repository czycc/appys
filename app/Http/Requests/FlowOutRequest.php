<?php

namespace App\Http\Requests;


class FlowOutRequest extends Request
{

    public function rules()
    {
        dd(\Auth::guard('api')->user()->balance);
        $rules =  [
            'total_amount' => 'required|numeric|max:' . \Auth::guard('api')->user()->balance,
            'out_method' => 'required|in:alipay,wechat',
        ];

        //支付宝填写账号
        if ($this->out_method == 'alipay') {
            $rules['ali_account'] = 'required|string';
        }

        //首次提现填写信息
        if (!\Auth::guard('api')->user()->extra) {
            $rules['name'] = 'required|string';
            $rules['idcard'] = 'required|string';
            $rules['health'] = 'required|string';
            $rules['extra'] = 'string';
        }
    }

    public function messages()
    {
        return [
            'total_amount.required' => '提现金额不能为空',
            'name.required' => '首次提现需完善用户信息-姓名',
            'idcard.required' => '首次提现需完善用户信息-身份证号',
            'health.required' => '首次提现需完善用户信息-健康状态',
        ];
    }
}
