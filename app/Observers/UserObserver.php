<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        if (empty($user->avatar)) {
            $user->avatar = 'https://woheniys.oss-cn-hangzhou.aliyuncs.com/logo.png';
        }
    }

    public function deleting(User $user)
    {
//        //删除关联文章
//        $user->articles()->delete();
//        //删除关联店铺
//        $user->shop()->delete();
//        //删除关联评论
//        $user->comments()->delete();
//        //取消所有绑定上级
//        User::update(['bound_id' => 0, 'bound_status' => 0])->where('bound_id', $user->id);
    }
}