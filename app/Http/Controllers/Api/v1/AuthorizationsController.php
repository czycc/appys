<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\AuthorizationRequest;
use App\Http\Requests\SocialAuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthorizationsController extends Controller
{

    public function store(AuthorizationRequest $request)
    {
        $cerd['phone'] = $request->phone;
        $cerd['password'] = $request->password;
        if (!$token = \Auth::guard('api')->attempt($cerd)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    /**
     * @param $type
     * @param SocialAuthorizationRequest $request
     *
     * 第三方授权登陆
     */
    public function SocialStore($type, SocialAuthorizationRequest $request)
    {
        if (!in_array($type, ['weixin'])) {
            return $this->response->errorBadRequest();
        }

        //第三方登陆

        $driver = Socialite::driver($type);
        try {
            if ($code = $request->code) {
                $res = $driver->getAccessTokenResponse($code);
                $token = array_get($res, 'access_token');
            } else {
                $token = $request->access_token;
                if ($type == 'weixin') {
                    $driver->setOpenId($request->openid);
                }
            }
            $oauthUser = $driver->userFromToken($token);
        } catch (\Exception $e) {
            return $this->response->errorUnauthorized('参数错误,无法获取用户信息');
        }


        $user = [];
        switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser
                    ->offsetGet('unionid') : null;
                if ($unionid) {
                    $user = User::where('wx_unionid', $unionid)->first();
                } else {
                    $user = User::where('wx_openid', $oauthUser->getId())->first();
                }

                if (!$user) {

                    //缓存微信数据数据
                    $expireAt = now()->addDay();
                    $wx_id = $unionid ?? $oauthUser->getId();
                    \Cache::put($wx_id, [
                        'wx_openid' => $oauthUser->getId(),
                        'wx_unionid' => $unionid,
                        'avatar' => $oauthUser->getAvatar(),
                    ], $expireAt);

                    return $this->response->array([
                        'message' => '用户未绑定手机号',
                        'wx_id' => $wx_id
                    ])->setStatusCode(202);
                }

                break;

        }
        $token = \Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token);
    }

    /**
     * @return mixed
     * 
     * 刷新令牌
     */
    public function update()
    {
        $token = \Auth::guard('api')->refresh();

        return $this->respondWithToken($token);
    }

    /**
     * @return \Dingo\Api\Http\Response
     *
     * 销毁令牌
     */
    public function destory()
    {
        \Auth::guard('api')->logout();

        return $this->response->noContent();
    }
    
    public function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
