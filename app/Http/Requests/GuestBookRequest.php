<?php

namespace App\Http\Requests;

class GuestBookRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'top_guest_id' => 'exists:guest_books,id',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => '留言内容必填',
            'body.string' => '留言内容格式有误',
            'user_id.exists' => '留言人不存在',
            'user_id.required' => '留言人id发送有误',
            'top_guest_id.exists' => '回复的留言人不存在'
        ];
    }
}
