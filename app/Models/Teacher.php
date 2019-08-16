<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    use SoftDeletes;

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
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

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

    public function setImgsAttribute($imgs)
    {

        if (is_array($imgs)) {
            foreach ($imgs as $k => $img) {
                //验证是否是链接
                if (!filter_var($img, FILTER_VALIDATE_URL)) {
                    $imgs[$k] = Storage::url($img);
                }
            }
            $this->attributes['imgs'] = json_encode($imgs);
        }
    }
}
