<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Order;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function index(Request $request)
    {
        $orders = [];
        if (session('teacher')) {
            $teacher = (object)session('teacher');
            //查询教师所属课程id
            $courses = Course::where('teacher_id', $teacher->id)->pluck('id');
            //查询所有子章节
            $chapters = Chapter::whereIn('course_id', $courses->toArray())->pluck('id');
            $orders = Order::whereNotNull('paid_at')
                ->where(function ($query) use ($courses) {
                    $query->where('type', 'course')
                        ->whereIn('type_id', $courses->toArray());
                })
                ->orWhere(function ($query) use ($chapters) {
                    $query->where('type', 'chapter')
                        ->whereIn('type_id', $chapters->toArray());
                })
                ->orderByDesc('id')
                ->paginate(10);
        }
        return view('teacher', compact('orders'));
    }

    public function login(Request $request)
    {
        $teacher = Teacher::where('name', $request->name)
            ->where('password', $request->password)
            ->first();

        if ($teacher) {
            session(['teacher' => $teacher]);
            return redirect('teacher');
        }
        return redirect('teacher')->with('message', '账号密码错误，请重试');
    }

    public function logout(Request $request)
    {
        $request->session()->pull('teacher');

        return redirect('teacher');
    }
}
