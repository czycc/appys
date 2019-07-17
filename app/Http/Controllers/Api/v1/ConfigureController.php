<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CompanyCategory;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigureController extends Controller
{
    /**
     * @return mixed
     *
     * 首页栏目名称
     */
    public function menu()
    {
        $company_categories = CompanyCategory::select(['id', 'name'])
            ->where('level', 0)
            ->get();
        $course_categories = CourseCategory::select(['id', 'name'])
            ->get();
        return $this->response->array([
            'company_categories' => $company_categories,
            'course_categories' => $course_categories,
            'video' => '用户视频',
            'article_audio' => '用户文章/用户音频'
        ]);
    }
}
