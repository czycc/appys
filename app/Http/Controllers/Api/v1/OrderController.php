<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Models\Article;
use App\Models\Chapter;
use App\Models\Configure;
use App\Models\Course;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Pay;

class OrderController extends Controller
{
    public function index(Request $request, Order $order)
    {
        $query = $order->query();

        $query->where('closed', 0)
            ->whereNotNull('paid_at');

        //按用户id查询
        if ($user_id = $request->user_id) {
            $query->where('user_id', $user_id);
        } else {
            //返回当前用户订单
            $query->where('user_id', $this->user()->id);
        }

        //按类型查询
        if ($request->type == 'course') {
            $query->whereIn('type', ['course']);
        } elseif ($request->type) {
            $query->where('type', $request->type);
        }

        $query->orderByDesc('id');

        $orders = $query->paginate(20);

        return $this->response->paginator($orders, new OrderTransformer());
    }

    public function store(OrderRequest $request)
    {
        $order = new Order();
        $order->user_id = $this->user()->id;
        $order->type = $request->type;

        switch ($type = $request->type) {
            //购买用户文章
            case 'article':
                $article = Article::find($request->type_id);
                $title = $article->title;
                $price = $article->price;
                $order->type = $article->media_type; //用于区分文章类型
                break;
            //购买vip
            case 'vip':

                //当前用户是代理，不允许购买会员
                if ($this->user()->vip == '代理会员') {
                    return $this->response->errorBadRequest('您已经是代理会员，无法购买银牌会员');
                }

                //根据是否有上级来决定vip价格
                $configure = Configure::select(['vip2_price_n', 'vip2_price_y'])
                    ->first();
                if ($this->user()->bound_status) {
                    $price = $configure['vip2_price_y'];
                } else {
                    $price = $configure['vip2_price_n'];
                }
                $title = '银牌会员';
                break;
            case 'course':
                $course = Course::find($request->type_id);
                $title = $course->title;

                //抵扣
                $deduction = $this->copperToMoney($course->now_price, $request->copper);
                $order->deduction = $deduction;
                $order->coin = $request->copper; //抵扣铜币
                $price = big_num($course->now_price)->subtract($deduction)->getValue();
                break;
            case 'chapter':
                $chapter = Chapter::find($request->type_id);
                $title = $chapter->title;

                //抵扣
                $deduction = $this->copperToMoney($chapter->price, $request->copper);
                $order->deduction = $deduction;
                $order->coin = $request->copper; //抵扣铜币
                $price = big_num($chapter->price)->subtract($deduction)->getValue();
                break;
            default:
                return $this->response->errorBadRequest('请求失败，请检查购买类型是否有误');
        }
        if ($price == 0) {
            return $this->response->errorBadRequest('该商品免费，无需购买');
        }
        $order->title = '购买 ' . emoji_reject($title);
        $order->total_amount = $price;
        $order->type_id = (int)$request->type_id;
        $order->save();

        //提交关闭订单队列
        $this->dispatch(new CloseOrder($order, config('app.order_ttl')));

        //不同支付方式
        if ($request->pay_method === 'wechat') {
            return $this->response->array([
                'data' => [
                    'order' => Pay::wechat()->app([
                        'out_trade_no' => $order->no,
                        'total_fee' => $order->total_amount * 100,
                        'body' => $order->title,
                    ])->getContent()
                ]]);

            //用于测试
//            return Pay::wechat()->scan([
//                'out_trade_no' => $order->no,
//                'total_fee' => $order->total_amount * 100,
//                'body' => $order->title,
//            ]);

        } elseif ($request->pay_method === 'wap') {
            return $this->response->array([
                'data' => [
                    'order' => Pay::wechat()->mp([
                        'out_trade_no' => $order->no,
                        'total_fee' => $order->total_amount * 100,
                        'body' => $order->title,
                        'openid' => $this->user()->wap_openid
                    ])
                ]]);
        } else {
            return $this->response->array([
                'data' => [
                    'order' => Pay::alipay()->app([
                        'out_trade_no' => $order->no,
                        'total_amount' => $order->total_amount,
                        'subject' => $order->title,
                    ])->getContent()
                ]]);
//        return Pay::alipay()->web([
//                   'out_trade_no' => $order->no,
//                   'total_amount' => $order->total_amount,
//                   'subject' => $order->title,
//              ]);
        }
    }

    public function copperToMoney($price, $copper)
    {
        $deduction = 0;
        if ($copper > 0) {
            $configure = Configure::first();

            //最大抵扣金额
            $max_deduction = big_num($price)
                ->multiply($configure['copper_pay_percent'] / 100)
                ->getValue();

            //实际抵扣金额
            $deduction = big_num(1)->multiply($copper / $configure['copper_pay_num'])->getValue();

            //不能超过最大抵扣
            if ($max_deduction < $deduction) {
                $deduction = $max_deduction;
            }
            //扣除当前用户铜币
            $this->user()
                ->decrement('copper', $deduction * $configure['copper_pay_num']);
        }

        return $deduction;
    }
}
