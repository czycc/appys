<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['no', 'title', 'total_amount', 'paid_at', 'pay_method', 'pay_no', 'type', 'type_id'];


}
