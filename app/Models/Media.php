<?php

namespace App\Models;


class Media extends Model
{
    protected $fillable = ['type', 'media_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
