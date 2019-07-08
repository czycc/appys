<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'media_url', 'zan_count', 'weight'];

}
