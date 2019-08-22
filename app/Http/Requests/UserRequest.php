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
        switch ($this->method()) {
            case 'POST':
                return [
                    'password' => 'required|string|min:6',
                    'verify_key' => 'required|string',
                    'verify_code' => 'required|string',
                    'wx_id' => 'string',
//                    'bound_id' => 'exists:users,phone'
                ];
                break;
            case 'PATCH':
                $userId = \Auth::guard('api')->id();
                return [
                    'nickname' => 'between:2,20|string',
                    'avatar' => 'string',
                    'code' => 'string',
                ];
                break;
        }

    }

    public function attributes()
    {
        return [
            'verify_key' => '短信验证码 key',
            'verify_code' => '短信验证码',
            'wx_id' => '微信',
            'code' => '授权码',
            'bound_id' => '推荐码'
        ];
    }

    public function messages()
    {
        return [
            'password.min' => '密码至少6位',
            'nickname' => '昵称在2-20个字符以内'
        ];
    }
}
