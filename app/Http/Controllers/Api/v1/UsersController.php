<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UserRequest;
use App\Models\User;
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
        $user = User::create([
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
            'code' => uniqid()
        ]);

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
}
