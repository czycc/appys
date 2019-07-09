<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\News;
use App\Transformers\NewsTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{

    public function index(Request $request, News $item)
    {
        $query = $item->query();

//        if ($categoryId = $request->input('category_id')) {
//            //查询固定分类，非父分类
//            $query->where('category_id', $categoryId);
//        }
        if ($request->input('order')) {
            //按权重排序
            $query->ordered();
        }
        if ($request->input('zan')) {
            //按点赞数排序
            $query->zan();
        }
        if ($request->input('recent')) {
            //是否按照最新时间排序
            $query->recent();
        }
        $paginate = $request->input('paginate') ?? 20;
        $items = $query->paginate($paginate);

        return $this->response->paginator($items, new NewsTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show(News $news)
    {
        return $this->response->item($news, new NewsTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
