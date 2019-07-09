<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $fillable = ['name', 'desc'];
    public $timestamps = false;
}
