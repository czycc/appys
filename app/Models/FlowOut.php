<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowOut extends Model
{
    protected $fillable =['total_amount', 'out_method', 'ali_account'];

    public $casts =[
        'status' => 'boolean',
        'out_status' => 'boolean',
    ];
}
