<?php

namespace App\Http\Requests;


class UserRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:6',
            'verify_key' => 'required|string',
            'verify_code' => 'required|string',
        ];
    }
    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
        ];
    }

    public function messages()
    {
        return [
           'password.min' => '密码至少6位',
        ];
    }
}
