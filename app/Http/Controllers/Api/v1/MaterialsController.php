<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Material;
use App\Transformers\MaterialTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;

class MaterialsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Material $post)
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

        return $this->response->paginator($posts, new MaterialTransformer());

    }

    public function show($id)
    {
        $post = Material::find($id);
        return $this->response->item($post, new MaterialTransformer());
    }

	public function create(Material $material)
	{
		return view('materials.create_and_edit', compact('material'));
	}

	public function store(MaterialRequest $request)
	{
		$material = Material::create($request->all());
		return redirect()->route('materials.show', $material->id)->with('message', 'Created successfully.');
	}

	public function edit(Material $material)
	{
        $this->authorize('update', $material);
		return view('materials.create_and_edit', compact('material'));
	}

	public function update(MaterialRequest $request, Material $material)
	{
		$this->authorize('update', $material);
		$material->update($request->all());

		return redirect()->route('materials.show', $material->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Material $material)
	{
		$this->authorize('destroy', $material);
		$material->delete();

		return redirect()->route('materials.index')->with('message', 'Deleted successfully.');
	}
}