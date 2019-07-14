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
                    'price' => 'required|integer',
                    'multi_imgs' => 'json',
                    'top_img' => 'required|string',
                    'type' => 'required|in:article,shop,video',
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
                    'type' => 'in:article,shop,video',
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
