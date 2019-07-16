<?php

namespace App\Models;

use Jcc\LaravelVote\Vote;

class Material extends Model
{
    use Vote;
    protected $vote = User::class;

    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'media_url', 'category_id', 'view_count', 'order'];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }
}
