<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|string|min:1|max:100',
            'comment_id' => 'required|exists:comments,id'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '内容不能为空',
            'content.max' => '最多输入100个字符',
            'content.min' => '最少输入1个字符',
            'comment_id.exists' => '回复的评论不存在',
            'comment_id.required' => '传入空的评论id'
        ];
    }
}
