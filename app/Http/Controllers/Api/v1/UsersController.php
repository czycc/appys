<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'nickname' => str_random(5)
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

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
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
}
