<?php

namespace App\Models;

class Chapter extends Model
{
    protected $fillable = ['title', 'price', 'media_type', 'media_url', 'couse_id'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
