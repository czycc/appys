<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\AuthorizationRequest;
use App\Http\Requests\SocialAuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthorizationsController extends Controller
{
    /**
     * @param AuthorizationRequest $request
     *
     * 用户登陆
     */
    public function store(AuthorizationRequest $request)
    {
        if ($request->password && is_null($request->verify_code) && is_null($request->verify_key)) {
            //密码登陆
            $cerd['phone'] = $request->phone;
            $cerd['password'] = $request->password;
            if (!$token = \Auth::guard('api')->attempt($cerd)) {
                return $this->response->errorBadRequest('用户名或密码错误');
            }

        } else {
            //验证码登陆
            $cerd = \Cache::get($request->verify_key);
            if (!$cerd) {
                return $this->response->error('验证码已经失效', 422);
            }
            if (!hash_equals($cerd['code'], $request->verify_code)) {
                return $this->response->errorBadRequest('验证码错误');
            }
//            if ($cerd['phone'] != $request->phone) {
//                return $this->response->errorBadRequest('验证码和手机号不对应');
//            }

            $user = User::where('phone', $cerd['phone'])->first();

            if (is_null($user)) {
                return $this->response->error('手机号不存在', 422);
            }
            //录入新密码
            if ($password = $request->password) {
                $user->password = bcrypt($password);
                $user->save();
            }

            $token = \Auth::guard('api')->fromUser($user);


        }
        //提取微信注册数据
        if ($request->wx_id) {
            $wx = \Cache::get($request->wx_id);
            if ($wx) {
                //更新微信信息
                $user = User::where('phone', $cerd['phone'])->first();
                $user->update($wx);
                \Cache::forget($request->wx_id);
            }

        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    /**
     * @param $type
     * @param SocialAuthorizationRequest $request
     *
     * 第三方授权登陆
     */
    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        if (!in_array($type, ['weixin', 'wap'])) {
            return $this->response->errorBadRequest('不可用的登陆方式');
        }

        //第三方登陆

        if ($type == 'wap') {
            //微信公众号h5
            $config = new \SocialiteProviders\Manager\Config(
                config('services.wap.client_id'),
                config('services.wap.client_secret'),
                ''
            );
            $driver = Socialite::driver('weixin')->setConfig($config);
        } else {
            //app
            $driver = Socialite::driver($type);
        }
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
            return $this->response->errorBadRequest('授权登陆失败，请重试');
        }


        $user = [];
        switch ($type) {
            case 'weixin':
            case 'wap':
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

                    if ($type === 'weixin') {
                        \Cache::put($wx_id, [
                            'wx_openid' => $oauthUser->getId(),
                            'wx_unionid' => $unionid,
                            'avatar' => $oauthUser->getAvatar(),
                        ], $expireAt);
                    } else {
                        \Cache::put($wx_id, [
                            'wap_openid' => $oauthUser->getId(),
                            'wx_unionid' => $unionid,
                            'avatar' => $oauthUser->getAvatar(),
                        ], $expireAt);
                    }


                    return $this->response->array([
                        'message' => '用户未绑定手机号',
                        'wx_id' => $wx_id
                    ])->setStatusCode(202);
                }

                //完善openid 用于企业付款
                if ($type === 'weixin' && is_null($user->wx_openid)) {
                    $user->update([
                        'wx_openid' => $oauthUser->getId()
                    ]);
                } elseif ($type === 'weixin' && is_null($user->wap_openid)) {
                    $user->update([
                        'wap_openid' => $oauthUser->getId()
                    ]);
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
