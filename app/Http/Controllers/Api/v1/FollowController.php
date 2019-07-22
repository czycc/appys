<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\FollowRequest;
use App\Models\User;
use App\Transformers\UserTransformer;

class FollowController extends Controller
{

    public function store(FollowRequest $request)
    {
        if ($request->type == 'follow') {
            $this->user()->follow($request->to_user_id);
        } else {
            $this->user()->unfollow($request->to_user_id);
        }
        return $this->response->created();
    }

    public function show(User $user, $type)
    {
        if ($type == 'followings') {
            //关注人
            $follows = $user->followings()->get();
        } elseif ($type == 'followers') {
            //粉丝
            $follows = $user->followers()->get();
        } else {
            return $this->response->errorBadRequest('错误的类型');
        }

        return $this->response->collection($follows, new UserTransformer(true));
    }
}
