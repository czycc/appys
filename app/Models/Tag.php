<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'desc'
    ];
    public $timestamps = false;

    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'taggable');
    }

    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }
}
