<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Configure;
use Illuminate\Http\Request;

class VipController extends Controller
{
    public function price()
    {
        $config = Configure::select(['vip2_price_n', 'vip2_price_y', 'vip3_price'])
            ->first()->toArray();
        $data['vip3_price'] = $config['vip3_price'];

        //根据是否有上级返回不同价格
        if ($this->user()->bound_status) {
            $data['vip2_price'] = $config['vip2_price_y'];
        } else {
            $data['vip2_price'] = $config['vip2_price_n'];
        }

        $data['bound_status'] = $this->user()->bound_status;

        return $this->response->array($data);
    }
}
