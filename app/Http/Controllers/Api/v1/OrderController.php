<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Models\Article;
use App\Models\Configure;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Pay;

class OrderController extends Controller
{
    public function index()
    {

    }


    public function create()
    {
        //
    }

    public function store(OrderRequest $request)
    {
        $order = new Order();
        $order->user_id = $this->user()->id;

        switch ($type = $request->type) {
            //购买用户文章
            case 'article':
                $article = Article::find($request->type_id);
                $title = $article->titile;
                $price = $article->price;
                break;
            //购买vip
            case 'vip':
                //根据是否有上级来决定vip价格
                $configure = Configure::select(['vip2_price_n', 'vip2_price_y'])
                    ->first();
                if ($this->user()->top_id) {
                    $price = $configure['vip2_price_y'];
                } else {
                    $price = $configure['vip2_price_n'];
                }
                $title = '银牌会员';
                break;
            case 'course':
                $course = Course::find($request->type_id);
                $title = $course->title;
                $price = $course->now_price;
                break;
            default:
                return $this->response->errorBadRequest('请求失败，请检查参数是否有误');
        }
        if ($price == 0) {
            return $this->response->errorBadRequest('该商品免费，无需购买');
        }
        $order->title = '购买 ' . $title;
        $order->total_amount = $price;
        $order->type = $type;
        $order->type_id = (int)$request->type_id;
        $order->save();

        //提交关闭订单队列
        $this->dispatch(new CloseOrder($order, config('app.order_ttl')));

        return $this->response->array([
            'data' => [
                'order' => Pay::alipay()->app([
                    'out_trade_no' => $order->no,
                    'total_amount' => $order->total_amount,
                    'subject' => $order->title,
                ])->getContent()
            ]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
