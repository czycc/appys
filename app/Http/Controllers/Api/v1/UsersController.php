<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UserRequest;
use App\Models\Media;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

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
            return $this->response->errorUnauthorized('验证码错误');
        }

        $data = [
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
            'code' => uniqid(),
            'nickname' => str_random(5),
            'bound_id' => $request->bound_id,
        ];

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
        return $this->response->item($user, new UserTransformer());
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


    public function update(UserRequest $request)
    {
        $user = $this->user();

        $attr = $request->only(['nickname', 'avatar_id']);
        if ($request->avatar_id) {
            $img = Media::find($request->avatar_id);
            $attr['avatar'] = $img->media_url;
        }
        $user->update($attr);

        return $this->response->item($user, new UserTransformer());
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
        $team = User::where('bound_id', $this->user()->id)->get();
        return $this->response->collection($team, new UserTransformer());
    }
}
