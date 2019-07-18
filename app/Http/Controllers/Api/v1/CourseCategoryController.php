<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CourseCategory;
use App\Transformers\CourseCategoryTransformer;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index()
    {
        return $this->response->collection(CourseCategory::all(), new CourseCategoryTransformer());
    }
}
