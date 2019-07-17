<?php

namespace App\Models;


class Media extends Model
{
    protected $fillable = ['type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
