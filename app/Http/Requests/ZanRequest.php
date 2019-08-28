<?php

namespace App\Http\Requests;

class ZanRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:article,company_post,course',
            'handler' => 'required|in:upvote,downvote'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '错误的点赞类型',
            'type.in' => '错误的点赞类型',
            'handler.required' => '错误的点赞操作',
            'handler.in' => '错误的点赞操作',

        ];
    }
}
