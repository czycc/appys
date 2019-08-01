<?php

namespace App\Http\Requests;

class ShopRequest extends Request
{
    public function rules()
    {
        switch ($this->method()) {
            // CREATE
            case 'POST':
                {
                    return [
                        'shop_phone' => [
                            'required',
                            'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                        ],
                        'real_name' => 'required|string',
                        'banner' => 'required|string',
                        'idcard' => 'required|string',
                        'license' => 'required|string',
                        'shop_imgs' => 'required|json',
                        'longitude' => 'required',
                        'latitude' => 'required',
                        'province' => 'required|string',
                        'city' => 'required|string',
                        'district' => 'required|string',
                        'address' => 'required|string',
                        'introduction' => 'required|string',
                        'wechat_qrcode' => 'string',
                        'tags' => 'json'
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'shop_phone' => [

                            'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                        ],
                        'real_name' => 'string',
                        'banner' => 'string',
                        'idcard' => 'string',
                        'license' => 'string',
                        'shop_imgs' => 'json',
                        'longitude' => 'numeric',
                        'latitude' => 'numeric',
                        'province' => 'string',
                        'city' => 'string',
                        'district' => 'string',
                        'address' => 'string',
                        'wechat_qrcode' => 'string',
                        'tags' => 'json'
                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }

    public function messages()
    {
        return [
            // Validation messages
            'phone.regex' => '手机号格式有问题',
        ];
    }
}
