<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Configure;
use Illuminate\Http\Request;

class PayController extends Controller
{
    /**
     * @return mixed
     *
     * 返回铜币使用最大比例和1元兑换铜币数量
     */
    public function copper()
    {
        $configure = Configure::select(['copper_pay_percent', 'copper_pay_num'])
            ->first();

        return $this->response->array(['data' => $configure]);
    }
}
