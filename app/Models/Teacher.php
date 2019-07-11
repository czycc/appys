<?php

namespace App\Models;

class Teacher extends Model
{
    protected $fillable = ['name', 'password', 'desc', 'video_url', 'imgs'];

    public function course()
    {
        return $this->hasMany(Course::class);
    }
}
