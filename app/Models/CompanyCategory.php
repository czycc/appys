<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $fillable = [
        'name', 'desc', 'parent_id'
    ];
    public $timestamps = false;
}
