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
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
            ],
            'password' => 'required_without:verify_key,verify_code|string|min:6',
            'verify_key' => 'required_without:password|string',
            'verify_code' => 'required_without:password|string',
            'wx_id' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => '手机格式错误。',
            'password.min' => '密码最少6位',
            'password.required_without' => '密码不能为空',
            'verify_code.required_without' => '验证码不能为空',
            'verify_key.required_without' => '验证码不能为空',
        ];
    }
}
