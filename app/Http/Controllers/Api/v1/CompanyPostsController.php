<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CompanyPost;
use App\Transformers\CompanyPostTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyPostRequest;

class CompanyPostsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, CompanyPost $post)
	{
	    $query = $post->query();

	    if ($categoryId = $request->input('category_id')) {
	        //查询固定分类，非父分类
	        $query->where('category_id', $categoryId);
        }
        if ($request->input('order')) {
            //按权重排序
            $query->ordered();
        }
//        if ($request->input('zan')) {
//            //按点赞数排序
//            $query->zan();
//        }
        if ($request->input('recent')) {
            //是否按照最新时间排序
            $query->recent();
        }
        $paginate = $request->input('paginate') ?? 20;
        $posts = $query->paginate($paginate);

        return $this->response->paginator($posts, new CompanyPostTransformer());

	}

    public function show($id)
    {
        $post = CompanyPost::find($id);
        return $this->response->item($post, new CompanyPostTransformer());
    }

	public function create(CompanyPost $company_post)
	{
		return view('company_posts.create_and_edit', compact('company_post'));
	}

	public function store(CompanyPostRequest $request)
	{
		$company_post = CompanyPost::create($request->all());
		return redirect()->route('company_posts.show', $company_post->id)->with('message', 'Created successfully.');
	}

	public function edit(CompanyPost $company_post)
	{
        $this->authorize('update', $company_post);
		return view('company_posts.create_and_edit', compact('company_post'));
	}

	public function update(CompanyPostRequest $request, CompanyPost $company_post)
	{
		$this->authorize('update', $company_post);
		$company_post->update($request->all());

		return redirect()->route('company_posts.show', $company_post->id)->with('message', 'Updated successfully.');
	}

	public function destroy(CompanyPost $company_post)
	{
		$this->authorize('destroy', $company_post);
		$company_post->delete();

		return redirect()->route('company_posts.index')->with('message', 'Deleted successfully.');
	}
}