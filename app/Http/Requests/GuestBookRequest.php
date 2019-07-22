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
            'body.required' => '留言内容不能为空',
        ];
    }
}
