<?php

namespace App\Models;

use App\Notifications\NormalNotify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GuestBook extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }
    public static function boot()
    {
        parent::boot();

        static::created(function (GuestBook $model) {

            if ($model->guest_book_id) {
                //回复留言发送通知
                $guestBook = GuestBook::find($model->guest_book_id);
                $user = User::find($guestBook->user_id);
                $user->msgNotify(new NormalNotify(
                    '留言被回复',
                    "{$model->user->nickname} 回复:{$model->body}",
                    'normal'
                ));
            } else {
                //通知用户留言
                $user = User::find($model->user_id);
                $user->msgNotify(new NormalNotify(
                    '新的店铺留言',
                    "{$model->guest->nickname} 留言:{$model->body}",
                    'normal'
                ));
            }
        });
    }
}
