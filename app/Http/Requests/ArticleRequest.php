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
            // Validation messages
        ];
    }
}
