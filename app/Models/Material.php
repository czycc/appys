<?php

namespace App\Models;

class Material extends Model
{
    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'media_url', 'category_id', 'view_count', 'order'];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }
}
