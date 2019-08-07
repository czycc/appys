<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Course;
use App\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Models\Order;

class CoursesController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Course $course)
	{
        $query = $course->query()->with('teacher', 'buynote', 'tags');
        //查询发布
        $query->where('show', 1);

        if ($tag_id = $request->input('tag_id')) {
            //根据标签id查询
            $query->whereHas('tags', function ($query) use($tag_id){
                $query->where('id', $tag_id);
            });
        }
        if ($request->input('recommend')) {
            //查询推荐
            $query->recommend();
        }
        if ($request->input('price_by')) {
            //按价格
            $query->orderBy('now_price', $request->input('price_by'));
        }
        if ($request->input('bought')) {
            //按购买人数
            $query->bought();
        }

        $posts = orderByRequest($request, $query);

        return $this->response->paginator($posts, new CourseTransformer(true));
    }

    public function show(Course $course)
    {
        $permission = false;
        //查询用户是否购买了课程
        if (
        Order::where('user_id', \Auth::guard('api')->user()->id)
            ->where('type_id', $course->id)
            ->where('type', 'course')
            ->whereNotNull('paid_at')
            ->first()
        ) {
            $permission = true;
        }
        return $this->response->item($course, new CourseTransformer(false, $permission));
    }

}