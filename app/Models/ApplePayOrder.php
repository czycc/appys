<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplePayOrder extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'extra' => 'json'
    ];
}
