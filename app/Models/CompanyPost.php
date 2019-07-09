<?php

namespace App\Models;

class CompanyPost extends Model
{
    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'media_url', 'category_id', 'view_count', 'zan_count', 'weight'];

    public function category()
    {
        return $this->belongsTo(CompanyCategory::class);
    }
}
