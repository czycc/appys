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
                            'regex:/^(1)\d{10}$/',
                        ],
                        'real_name' => 'required|string|min:2|max:5',
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
                        'real_name' => 'string|min:2|max:5',
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
            'phone.required' => '手机号格式有问题',
            'real_name.required' => '真实姓名在2-5个字符',
            'real_name.min' => '真实姓名在2-5个字符',
            'real_name.max' => '真实姓名在2-5个字符',
            'banner.required' => '必须上传主图',
            'banner.string' => '必须上传主图',
            'idcard.required' => '必须上传身份证',
            'idcard.string' => '必须上传身份证',
            'license.string' => '必须上传营业执照',
            'license.required' => '必须上传营业执照',
            'province.string' => '请正确填写省市区',
            'province.required' => '请正确填写省市区',
            'city.string' => '请正确填写省市区',
            'city.required' => '请正确填写省市区',
            'district.string' => '请正确填写省市区',
            'district.required' => '请正确填写省市区',
            'address.string' => '请正确填写详细地址',
            'address.required' => '请正确填写详细地址',
            'introduction.string' => '请正确填写介绍',
            'introduction.required' => '请正确填写介绍',
        ];
    }
}
