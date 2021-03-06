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
            'to_user_id.required' => '程序未上传正确关注用户',
            'to_user_id.exists' => '关注用户不存在',
            'type.in' => '只有follow关注，unfollow取关，两种方式',
            'type' => '程序未传入正确关注方式'
        ];
    }
}
