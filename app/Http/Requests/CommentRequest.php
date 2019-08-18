<?php

namespace App\Http\Requests;

class CommentRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'content' => 'required|min:1',
                    'comment_id' => 'required_without:article_id|exists:comments,id',
                    'article_id' => 'required_without:comment_id|exists:articles,id'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
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
            'content.required' => '评论内容必填',
            'content.min' => '评论内容至少一个字符',
        ];
    }
}
