<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\VerificationCodeRequest;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class VerificationCodesController extends Controller
{
    /**
     * @param VerificationCodeRequest $request
     * @param EasySms $easySms
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     *
     * 发送验证码
     */
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
                    'template' => 'SMS_165414240',
                    'data' => [
                        'number' => $code
                    ]
                ]);
            } catch (NoGatewayAvailableException $exception) {
                $msg = $exception->getException('aliyun')->getMessage();
                return $this->response->errorBadRequest($msg ?: '短信网络发送异常');
            }
        }

        //缓存验证码，5分钟过期
        $key = 'verificationCode_' . uniqid();
        $expireAt = now()->addMinute(5);

        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expireAt);

        return $this->response->array([
            'verify_key' => $key,
            'expireAt' => $expireAt->toDateTimeString(),
        ])->setStatusCode(201);
    }

}
