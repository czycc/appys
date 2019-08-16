<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * 后台获取课程列表
     */
    public function courses(Request $request)
    {
        $q = $request->get('q');
        return Course::where('title', 'like', "%$q%")->paginate(null, ['id', 'title as text']);
    }

    /**
     * @param Request $request
     * @return mixed
     *
     * 后台获取教师列表
     */
    public function teachers(Request $request)
    {
        $q = $request->get('q');
        return Teacher::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);

    }
}
