<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attention extends Model
{
    protected $fillable = ['to_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
