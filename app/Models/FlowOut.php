<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowOut extends Model
{
    protected $guarded =['id', 'created_at', 'updated_at'];

    public $casts =[
        'status' => 'boolean',
        'out_status' => 'boolean',
    ];
}
