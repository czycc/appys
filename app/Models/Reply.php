<?php

namespace App\Models;

use App\Notifications\NormalNotify;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Reply $model) {
            //评论被回复发送通知
            $model->comment->user->msgNotify(new NormalNotify(
                '评论被回复',
                "{$model->user->nickname} 回复了你:{$model->content}",
                'normal'
            ));
        });
    }
}
