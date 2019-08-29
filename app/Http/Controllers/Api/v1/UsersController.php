<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\BoundScanRequest;
use App\Http\Requests\UserRequest;
use App\Models\BoundScan;
use App\Models\Configure;
use App\Models\Media;
use App\Models\User;
use App\Notifications\UserBound;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Laravel\Socialite\Facades\Socialite;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param UserRequest $request
     * 用户注册接口
     */
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verify_key);
        if (!$verifyData) {
            return $this->response->error('验证码已经失效', 422);
        }
        if (!hash_equals($verifyData['code'], $request->verify_code)) {
            return $this->response->errorBadRequest('验证码错误');
        }

        //bound_id改为用户手机号，用于绑定上级
        $bound = User::where('phone', $request->bound_id)->first();


        $data = [
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
            'code' => uniqid(),
            'nickname' => str_random(5),
        ];

        //绑定
        if ($bound) {
            $data['bound_id'] = $bound->id;
            $data['bound_status'] = 1;

            //上级增加铜币
            $bound->increment('copper', Configure::first()->invite_copper);
        }

        //提取微信注册数据
        if ($request->wx_id) {
            $wx = \Cache::get($request->wx_id);
            if ($wx) {
                $data = array_merge($data, $wx);
                \Cache::forget($request->wx_id);
            }

        }

        $user = User::create($data);

        //清除验证码
        \Cache::forget($request->verify_key);

        return $this->response->array([
            'access_token' => \Auth::guard('api')->fromUser($user),
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->response->item($user, new UserTransformer(false, true));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * @param UserRequest $request
     * @return \Dingo\Api\Http\Response
     *
     * 更新头像昵称
     */
    public function update(UserRequest $request)
    {

        $attr = $request->only(['nickname', 'avatar']);
//        if ($request->avatar_id) {
//            $img = Media::find($request->avatar_id);
//            $attr['avatar'] = $img->media_url;
//        }
        //app已登陆微信绑定
        if ($code = $request->code) {
            try {
                $driver = Socialite::driver('weixin');
                $res = $driver->getAccessTokenResponse($code);
                $token = array_get($res, 'access_token');
                $oauthUser = $driver->userFromToken($token);

            } catch (\Exception $e) {
                return $this->response->errorBadRequest('授权登陆失败，请重试');
            }

            $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser
                ->offsetGet('unionid') : null;
            if ($unionid) {
                $user = User::where('wx_unionid', $unionid)->first();
            } else {
                $user = User::where('wx_openid', $oauthUser->getId())->first();
            }

            //用户已绑定
            if ($user) {
                return $this->response->errorBadRequest('该微信已经绑定过用户');
            }

            $attr['wx_openid'] = $oauthUser->getId();
            $attr['wx_unionid'] = $unionid;
        }

        $this->user()->update($attr);

        return $this->response->item($this->user(), new UserTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @return \Dingo\Api\Http\Response
     * 返回当前用户信息
     */
    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }

    /**
     * @return \Dingo\Api\Http\Response
     *
     * 返回我的团队
     */
    public function team()
    {
        $team = User::where('bound_id', $this->user()->id)
            ->where('bound_status', 1)
            ->orderByDesc('id')
            ->paginate(20);
        return $this->response->paginator($team, new UserTransformer(true));
    }

    /**
     * @param BoundScanRequest $request
     * @return \Dingo\Api\Http\Response|void
     *
     * 扫推荐码绑定上级
     */
    public function boundFormScan(BoundScanRequest $request)
    {
        $code = $request->input('code');

        //判断是否绑定上级
        if ($this->user()->bound_status !== 0) {
            return $this->response->errorBadRequest('您已经绑定过上级');
        }

        //判断是否已经有申请
        $bound = BoundScan::where('user_id', $this->user()->id)
            ->where('status', 0)//0代表未处理
            ->first();
        if ($bound) {
            return $this->response->errorBadRequest('您已经提交过绑定申请，等待确认');
        }

        $user = User::where('phone', $code)->first();

        //不能循环上下级
        if ($user->bound_id) {
            if ($user->bound_id === $this->user()->id) {
                return $this->response->errorBadRequest('不能循环绑定上下级');
            } else {
                if ($top = User::find($user->bound_id)) {
                    if ($top->bound_id === $this->user()->id) {
                        return $this->response->errorBadRequest('不能循环绑定上下级');
                    }
                }
            }
        }

        //自己的二维码
        if ($user->id == $this->user()->id) {
            return $this->response->error('亲，这是您自己的二维码', 422);
        }

        $bound = new BoundScan();
        $bound->user_id = $this->user()->id;
        $bound->bound_id = $user->id;
        $bound->save();

        //插入绑定上级的id
        $this->user()->bound_id = $user->id;
        $this->user()->save();

        //消息通知
        $user->msgNotify(new UserBound($this->user(), $bound->id));


        return $this->response->created();
    }

    /**
     * @param DatabaseNotification $notify
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     * @throws \Exception
     *
     * 确认绑定上级
     */
    public function scanConfirm(DatabaseNotification $notify, Request $request)
    {
        $bound = BoundScan::find($notify->data['type_id']);
        //是否是本人
        if ($bound->bound_id !== $this->user()->id) {
            return $this->response->errorBadRequest('非上级');
        }
        if ($bound->status) {
            return $this->response->errorBadRequest('申请已经处理过了');
        }
        $user = User::find($bound->user_id);

        //确认绑定 判断bound_id+bound_status
        if ($confirm = $request->confirm) {
            $user->bound_status = 1;
            //该用户增加铜币
            $this->user()->increment('copper', Configure::first()->invite_copper);

        } else {
            //取消上级绑定
            $user->bound_id = 0;
            $user->bound_status = 0;
        }
        $user->save();

        //标记已处理绑定
        $bound->status = 1;
        $bound->save();

        $notify->delete();

        return $this->response->noContent();
    }
}
