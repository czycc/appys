<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Shop;
use App\Transformers\ShopTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;

class ShopsController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::query()->with('tags');

        if ($tag_id = $request->input('tag_id')) {
            //根据标签id查询
            $query->whereHas('tags', function ($query) use($tag_id){
                $query->where('id', $tag_id);
            });
        }

        $shops = $query->where('expire_at', '>', Carbon::now())
            ->where('status', 1)
            ->orderByDesc('order')
            ->orderByDesc('zan_count')
            ->paginate(20);

        return $this->response->paginator($shops, new ShopTransformer(true));
    }


    public function store(ShopRequest $request, Shop $shop)
    {
        $this->authorize('create', $shop);

        $userId = $this->user()->id;

        if (Shop::where('user_id', $userId)->first()) {
            return $this->response->errorBadRequest('店铺申请已经提交');
        }

        $shop->fill($request->all());
        $shop->user_id = $userId;
        $shop->status = 2; //防止transformer返回null
        $shop->save();

        if ($request->tags) {
            $shop->tags()->attach(json_decode($request->tags));
        }
        return $this->response->item($shop, new ShopTransformer())
            ->setStatusCode(201);
    }


    public function update(ShopRequest $request, Shop $shop)
    {
        $this->authorize('update', $shop);

        $shop->update($request->all());
        if ($request->tags) {
            $shop->tags()->sync(json_decode($request->tags));
        }
        return $this->response->item($shop, new ShopTransformer());
    }
}