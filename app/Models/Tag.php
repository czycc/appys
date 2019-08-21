<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function shops()
    {
        return $this->morphedByMany(Shop::class, 'taggable');
    }

    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }

    public function CompanyPosts()
    {
        return $this->morphedByMany(CompanyPost::class, 'taggable');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            DB::table('taggables')->where('tag_id', $model->id)->delete();
        });
    }
}
