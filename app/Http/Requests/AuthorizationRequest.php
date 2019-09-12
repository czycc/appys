<?php

namespace App\Http\Requests;


class AuthorizationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required_without:verify_key,verify_code',
                'regex:/^(1)\d{10}$/',
            ],
            'password' => 'required_without:verify_key,verify_code|string|min:6',
            'verify_key' => 'string',
            'verify_code' => 'string',
            'wx_id' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => '手机格式错误。',
            'phone.required_without' => '手机格式错误。',
            'password.min' => '密码最少6位',
            'password.required_without' => '密码必填',
            'verify_key.string' => '错误的验证码格式',
            'verify_code.string' => '错误的验证码格式',
        ];
    }
}
