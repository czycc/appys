<?php

namespace App\Models;

class Comment extends Model
{
    protected $fillable = ['article_id', 'user_id', 'comment_id', 'content'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'comment_id');
    }
}
