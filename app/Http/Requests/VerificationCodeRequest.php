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
                    'regex:/^(1)\d{10}$/',
                    'unique:users'
                ]
            ];
        } elseif ($this->type == 'login') {
            return [
                'phone' => [
                    'required',
                    'regex:/^(1)\d{10}$/',
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