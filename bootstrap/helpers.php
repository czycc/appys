<?php
/**
 * @param $request
 * @param $query
 * @return mixed
 *
 * 按请求参数进行排序
 */
function orderByRequest($request, $query)
{
    if ($categoryId = $request->input('category_id')) {
        //查询固定分类id下
        $query->where('category_id', $categoryId);
    }
    if ($request->input('order')) {
        //按权重排序
        $query->ordered();
    }
    if ($request->input('recent')) {
        //是否按照最新时间排序
        $query->recent();
    }
    if ($request->input('viewed')) {
        $query->viewed();
    }
    $paginate = $request->input('paginate') ?? 20;
    $query = $query->paginate($paginate);
    return $query;
}
