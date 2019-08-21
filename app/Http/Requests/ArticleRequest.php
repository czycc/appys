<?php

namespace App\Http\Requests;

class ArticleRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                $userId = \Auth::guard('api')->id();
                return [
                    // CREATE ROLES
                    'title' => 'required|string',
                    'body' => 'required|string',
                    'price_id' => 'required|exists:article_prices,id',
                    'multi_imgs' => 'required|json',
//                    'top_img' => 'required|string',
                    'media_type' => 'required|in:topic,audio,video',
                    'media_url' => 'string',
                    'tags' => 'json'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'string',
                    'body' => 'string',
                    'price' => 'integer',
                    'multi_imgs' => 'json',
                    'top_img' => 'string',
                    'media_type' => 'in:topic,audio,video',
                    'media_url' => 'string',
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
            'title.required' => '标题必填',
            'title.string' => '标题格式错误',
            'body.required' => '内容必填',
            'body.string' => '内容格式错误',
            'price_id.exists' => '价格错误，请重试',
            'price_id.required' => '价格必选',
            'multi_imgs.required' => '图片至少上传一张',
            'multi_imgs.json' => '图片上传有误',
            'media_type.required' => '媒体类型必选',
            'media_url.string' => '错误的媒体链接',
            'tags.json' => '错误的标签，请重试'

        ];
    }
}