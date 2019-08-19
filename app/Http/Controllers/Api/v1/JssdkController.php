<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

class JssdkController extends Controller
{
    public function jssdk(Request $request)
    {
        $officialAccount = \EasyWeChat::officialAccount();
        $officialAccount->jssdk->setUrl($request->url);
        $jssdk = $officialAccount->jssdk->buildConfig((array)$request->apis, $debug = $request->debug, $beta = false, $json = true);
        return $this->response->array([
            'data' => $jssdk
        ]);
    }
}
