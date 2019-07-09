<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Teacher;
use App\Transformers\TeacherTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        dd($teacher);
        return $this->response->item($teacher, new TeacherTransformer());
    }

	public function create(Teacher $teacher)
	{
		return view('teachers.create_and_edit', compact('teacher'));
	}

	public function store(TeacherRequest $request)
	{
		$teacher = Teacher::create($request->all());
		return redirect()->route('teachers.show', $teacher->id)->with('message', 'Created successfully.');
	}

	public function edit(Teacher $teacher)
	{
        $this->authorize('update', $teacher);
		return view('teachers.create_and_edit', compact('teacher'));
	}

	public function update(TeacherRequest $request, Teacher $teacher)
	{
		$this->authorize('update', $teacher);
		$teacher->update($request->all());

		return redirect()->route('teachers.show', $teacher->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Teacher $teacher)
	{
		$this->authorize('destroy', $teacher);
		$teacher->delete();

		return redirect()->route('teachers.index')->with('message', 'Deleted successfully.');
	}
}