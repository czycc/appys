<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CompanyCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyCategoryController extends Controller
{
    public function index()
    {
        return $this->response->array(CompanyCategory::all());
    }
}
