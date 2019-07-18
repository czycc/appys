<?php

namespace App\Http\Requests;


class VerificationCodeRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->type == 'register') {
            return [
                'phone' => [
                    'required',
                    'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                    'unique:users'
                ]
            ];
        } elseif ($this->type == 'login') {
            return [
                'phone' => [
                    'required',
                    'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                    'exists:users,phone'
                ]
            ];
        }

    }

    public function messages()
    {
        return [
            'phone.regex' => '手机格式错误',
            'phone.unique' => '手机号已经被注册',
            'phone.exists' => '手机号不存在，请检查'
        ];
    }
}