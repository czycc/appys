<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    public function courses(Request $request)
    {
        $q = $request->get('q');
        return Course::where('title', 'like', "%$q%")->paginate(null, ['id', 'title as text']);
    }

    public function teachers(Request $request)
    {
        $q = $request->get('q');
        return Teacher::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);

    }
}
