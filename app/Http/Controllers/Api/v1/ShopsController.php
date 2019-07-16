<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Shop;
use App\Transformers\ShopTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;

class ShopsController extends Controller
{
    public function __construct()
    {

    }

	public function index()
	{
		$shops = Shop::paginate();
		return view('shops.index', compact('shops'));
	}

    public function show(Shop $shop)
    {
        return view('shops.show', compact('shop'));
    }

	public function store(ShopRequest $request, Shop $shop)
	{
	    $userId = $this->user()->id;

	    if (Shop::where('user_id', $userId)->first()) {
	        return $this->response->errorBadRequest('店铺申请已经提交');
        }
	    if ($this->user()->vip !== 2 && $this->user()->vip !== 1) {
	        //未注册vip
            return $this->response->errorBadRequest('非会员用户');
        }

	    $shop->fill($request->all());
	    $shop->user_id = $userId;
	    $shop->save();

        if ($request->tags) {
            $this->user()->tags()->attach(json_decode($request->tags));
        }
	    return $this->response->item($shop, new ShopTransformer())
            ->setStatusCode(201);
	}


	public function update(ShopRequest $request, Shop $shop)
	{
		$this->authorize('update', $shop);
		$shop->update($request->all());
        if ($request->tags) {
            $this->user()->tags()->sync(json_decode($request->tags));
        }
		return $this->response->item($shop, new ShopTransformer());
	}

	public function destroy(Shop $shop)
	{
		$this->authorize('destroy', $shop);
		$shop->delete();

		return redirect()->route('shops.index')->with('message', 'Deleted successfully.');
	}
}