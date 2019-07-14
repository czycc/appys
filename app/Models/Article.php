<?php

namespace App\Models;

class Article extends Model
{
    protected $fillable = ['title', 'top_img', 'body', 'type', 'media_url', 'multi_imgs', 'price'];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
