<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\VerificationCodeRequest;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;
        if (!app()->environment('production')) {
            //测试环境不发送验证码
            $code = '1234';
        } else {
            $code = str_pad(random_int(0, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send($phone, [
                    'content' => "【上汽名爵】您的验证码是{$code}，有效期三分钟"
                ]);
            } catch (NoGatewayAvailableException $exception) {
                $msg = $exception->getException('yunpian')->getMessage();
                return $this->response->errorInternal($msg ?: '短信发送异常');
            }
        }

        //缓存验证码，3分钟过期
        $key = 'verificationCode_' . uniqid();
        $expireAt = now()->addMinute(3);

        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expireAt);

        return $this->response->array([
            'verify_key' => $key,
            'expireAt' => $expireAt->toDateTimeString(),
        ])->setStatusCode(201);
    }

}
