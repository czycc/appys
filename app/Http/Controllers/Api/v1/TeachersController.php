<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Teacher;
use App\Transformers\TeacherTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherRequest;

class TeachersController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$teachers = Teacher::paginate();
		return view('teachers.index', compact('teachers'));
	}

    public function show(Teacher $teacher)
    {
        return $this->response->item($teacher, new TeacherTransformer());
    }

}