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
        if ($this->out_method == 'wechat' && !\Auth::guard('api')->user()->wx_unionid) {
            $rules['bound_wechat'] = 'required';
        }

        //首次提现填写信息
        if (!\Auth::guard('api')->user()->extra) {
            $rules['name'] = 'required|string|between:2,5';
            $rules['idcard'] = 'required|regex:/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/';
            $rules['health'] = 'required|string';
            $rules['extra'] = 'string';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => '姓名',
            'idcard' => '身份',
            'health' => '健康信息',
            'extra' => '备注',
            'ali_account' => '支付宝账号'
        ];
    }

    public function messages()
    {
        return [
            'total_amount.required' => '提现金额不能为空',
            'total_amount.max' => '提现金额不能超过当前收益余额',
            'name.required' => '首次提现需完善用户信息-姓名',
            'idcard.required' => '首次提现需完善用户信息-身份证号',
            'health.required' => '首次提现需完善用户信息-健康状态',
            'bound_wechat.required' => '微信需要绑定账号',
            'idcard.regex' => '身份证号格式错误'
        ];
    }
}
