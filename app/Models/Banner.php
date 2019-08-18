<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
//    protected $fillable = ['desc', 'img_url', 'type', 'type_id', 'order'];
    protected $guarded = ['id'];

    protected $casts = [
        'desc' => 'string'
    ];
    public function setImgUrlAttribute($img)
    {
        //用于后台上传保存完整地址
        if (!filter_var($img, FILTER_VALIDATE_URL)) {
            $this->attributes['img_url'] = Storage::url($img);
        } else {
            $this->attributes['img_url'] = $img;
        }
    }

    public function getDescAttribute($desc)
    {
        if (is_null($desc)) {
            return '';
        }
        return $desc;
    }
}
