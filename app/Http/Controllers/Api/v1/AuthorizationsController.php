<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\SocialAuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthorizationsController extends Controller
{
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

        return $this->response->array(['token' => $user->id]);
    }
}
