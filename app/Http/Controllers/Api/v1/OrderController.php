<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Models\Article;
use App\Models\Chapter;
use App\Models\Configure;
use App\Models\Course;
use App\Models\Flow;
use App\Models\Order;
use App\Models\User;
use App\Models\UserCoin;
use App\Notifications\NormalNotify;
use App\Transformers\OrderTransformer;
use Carbon\Carbon;
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
        if ($request->pay_method === 'wechat') {
            return $this->response->errorBadRequest('微信支付升级中，请使用支付宝支付');
        }
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
        } elseif ($request->pay_method === 'ios') {
            $fee = $order->total_amount * 100;
            if ($this->user()->coin() < $fee) {
                return $this->response->errorBadRequest('当前用户钻石不足');
            }
            $userCoin = UserCoin::where('user_id', $this->user()->id)->first();
            $userCoin->coin -= $fee;
            $userCoin->save();
            $order->update([
                'paid_at' => Carbon::now(),
                'pay_method' => 'ios',
                'pay_no' => $order->no
            ]);
            $this->cps($order, $this->user());
            return $this->response->array([
                'massage' => '购买成功',
                'coin' => $userCoin->coin
            ]);
        }else {
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

    /**
     * @param Order $order
     * @param User $user
     *
     * 分销&支付后相关逻辑处理
     */
    public function cps(Order $order, User $user)
    {
        $configure = Configure::first();
        //根据订单用户分成
        switch ($type = $order->type) {
            //购买用户文章
            case 'audio':
            case 'video':
            case 'topic':
                $article = Article::find($order->type_id);
                if ($article->media_type == 'audio') {
                    $titleType = '音频购买';
                } elseif ($article->media_type == 'video') {
                    $titleType = '小视频';
                } elseif ($article->media_type == 'topic') {
                    $titleType = '文章';
                } else {
                    $titleType = '作品';
                }
                Flow::create([
                    'title' => $titleType . '收益',
                    'user_id' => $article->user_id,
                    'order_id' => $order->id,
                    'total_amount' => big_num($order->total_amount)
                        ->multiply($configure['pub_self'] / 100)
                        ->getValue(),
                    'extra' => $article->media_type,
                ]);
                //发送通知
                $article->user->msgNotify(new NormalNotify(
                    '作品被购买',
                    "您的作品 {$article->title} 被 {$user->nickname} 购买",
                    'normal',
                    $article->id
                ));

                break;
            //购买vip
            case 'vip':

                //一级分成虚拟币，自己购买会员得银币,三级分销
                $user->silver += $configure->buy_vip2_self;
                //更新会员
                $user->vip = 1;
                if ($user->expire_at < Carbon::now()) {
                    $user->expire_at = Carbon::now()->addYear();
                } else {
                    $user->expire_at = $user->expire_at->addYear();
                }
                $user->save();

                if ($user->bound_status) {

                    //上级是代理得金币，是银牌得银币
                    $top = User::find($user->bound_id);
                    if ($top->vip === '银牌会员') {
                        $top->silver += $configure->buy_vip2_top_vip2;
                    } elseif ($top->vip === '代理会员') {
                        //代理
                        $top->gold += $configure->buy_vip2_top_vip3;
                    }
                    $top->save();

                    if ($top->vip !== '铜牌会员') {
                        //会员购买三级分销
                        Flow::create([
                            'title' => '会员邀请收益',
                            'user_id' => $top->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute1_vip / 100)
                                ->getValue(),
                            'extra' => '会员一级分销',
                        ]);
                    }


                    if ($top->bound_status) {
                        $top2 = User::find($top->bound_id);
                        if ($top2->vip !== '铜牌会员') {
                            Flow::create([
                                'title' => '会员邀请收益',
                                'user_id' => $top2->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute2_vip / 100)
                                    ->getValue(),
                                'extra' => '会员二级分销'
                            ]);
                        }
                        if ($top2->bound_status) {
                            $top3 = User::find($top2->bound_id);

                            if ($top3->vip !== '铜牌会员') {
                                Flow::create([
                                    'title' => '会员邀请收益',
                                    'user_id' => $top3->id,
                                    'order_id' => $order->id,
                                    'total_amount' => big_num($order->total_amount)
                                        ->multiply($configure->distribute3_vip / 100)
                                        ->getValue(),
                                    'extra' => '会员三级级分销'
                                ]);
                            }
                        }
                    }
                }

                break;
            case 'course':
            case 'chapter':

                //提高课程购买数
                if ($type == 'course') {
                    Course::where('id', $order->type_id)->increment('buy_count', 1);
                } else {
                    Course::where('id', Chapter::find($order->type_id)->course_id)->increment('buy_count', 1);
                }

                //购买课程或章节， 三级分销
                if ($user->bound_status) {
                    $top = User::find($user->bound_id);
                    if ($top->vip !== '铜牌会员') {
                        //收益
                        Flow::create([
                            'title' => '课程购买收益',
                            'user_id' => $top->id,
                            'order_id' => $order->id,
                            'total_amount' => big_num($order->total_amount)
                                ->multiply($configure->distribute1_course / 100)
                                ->getValue(),
                            'extra' => '课程一级分销',
                        ]);
                    }
                    if ($top->bound_status) {
                        $top2 = User::find($top->bound_id);

                        if ($top2->vip !== '铜牌会员') {
                            //收益
                            Flow::create([
                                'title' => '课程购买收益',
                                'user_id' => $top2->id,
                                'order_id' => $order->id,
                                'total_amount' => big_num($order->total_amount)
                                    ->multiply($configure->distribute2_course / 100)
                                    ->getValue(),
                                'extra' => '课程二级分销',
                            ]);
                        }

                        if ($top->bound_status) {
                            $top3 = User::find($top2->bound_id);

                            if ($top3->vip !== '铜牌会员') {
                                //收益
                                Flow::create([
                                    'title' => '课程购买收益',
                                    'user_id' => $top3->id,
                                    'order_id' => $order->id,
                                    'total_amount' => big_num($order->total_amount)
                                        ->multiply($configure->distribute3_course / 100)
                                        ->getValue(),
                                    'extra' => '课程三级分销',
                                ]);
                            }
                        }
                    }
                }
                break;
        }
    }
}
