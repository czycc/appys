<?php

namespace App\Models;

class Teacher extends Model
{
    protected $fillable = ['name', 'password', 'desc', 'video_url', 'imgs'];

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $value
     * @return mixed
     *
     * json转数组
     */
    public function getImgsAttribute($value)
    {
        return json_decode($value, true);
    }
}
