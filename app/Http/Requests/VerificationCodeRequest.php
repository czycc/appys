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
        return [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                'unique:users'
            ]
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => '手机格式错误',
            'phone.unique' => '手机号已经被注册',
        ];
    }
}