<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\FlowOutRequest;
use App\Models\Flow;
use App\Models\FlowOut;
use App\Models\UserExtra;
use App\Transformers\FlowOutTransformer;
use App\Transformers\FlowTransformer;
use Illuminate\Http\Request;

class FlowController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     *
     * 当前用户流水列表
     */
    public function index()
    {
        $flows = Flow::select(['id', 'title', 'total_amount', 'created_at'])
            ->where('user_id', $this->user()->id)
            ->where('total_amount', '>', 0)
            ->orderByDesc('id')
            ->paginate(20);

        return $this->response
            ->paginator($flows, new FlowTransformer())
            ->addMeta('balance', $this->user()->balance)
            ->addMeta('bound_extra', (boolean)$this->user()->extra);
    }

    /**
     * @return mixed
     *
     * 当前用户提现列表
     */
    public function flowOutList()
    {
        $outs = FlowOut::select(['id', 'total_amount', 'created_at', 'status', 'out_status'])
            ->where('user_id', $this->user()->id)
            ->orderByDesc('id')
            ->paginate(20);

        return $this->response->paginator($outs, new FlowOutTransformer());
    }

    /**
     * @param FlowOutRequest $request
     * @param FlowOut $flowOut
     * @return mixed
     *
     * 提交提现
     */
    public function flowOutStore(FlowOutRequest $request, FlowOut $flowOut)
    {
        return $this->response->errorBadRequest('提现将于近期开放，敬请期待');
        if (!$this->user()->extra) {
            $extra = new UserExtra();

            $extra->name = $request->name;
            $extra->idcard = $request->idcard;
            $extra->health = $request->health;
            $extra->extra = $request->extra;
            $extra->user_id = $this->user()->id;
            $extra->save();
        }

        $flowOut->fill($request->all());
        $flowOut->user_id = $this->user()->id;
        $flowOut->status = 0;
        $flowOut->out_status = 0;
        $flowOut->save();
        return $this->response->array(['data' => $flowOut])->setStatusCode(201);
    }
}
