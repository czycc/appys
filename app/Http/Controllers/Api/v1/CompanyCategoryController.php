<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CompanyCategory;
use App\Transformers\CommentTransformer;
use App\Transformers\CompanyCategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyCategoryController extends Controller
{
    public function index()
    {
        return $this->response->collection(CompanyCategory::all(), new CompanyCategoryTransformer());
    }
}
