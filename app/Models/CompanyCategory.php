<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $fillable = [
        'name', 'desc'
    ];
    public $timestamps = false;

    public function post()
    {
        return $this->hasMany(CompanyPost::class, 'category_id');
    }
}
