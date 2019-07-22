<?php

namespace App\Http\Requests;


class FollowRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'to_user_id' => 'required|exists:users,id',
            'type' => 'required|in:follow,unfollow',
        ];
    }

    public function messages()
    {
        return [
            'to_user_id.exists' => '关注用户不存在',
            'type.in' => '类型只有follow，unfollow'
        ];
    }
}
