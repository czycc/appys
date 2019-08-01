<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\FlowOutRequest;
use App\Models\Flow;
use App\Models\FlowOut;
use App\Transformers\FlowTransformer;
use Illuminate\Http\Request;

class FlowController extends Controller
{
    public function index()
    {
        $flows = Flow::select(['id', 'title', 'total_amount'])
            ->where('user_id', $this->user()->id)
            ->orderByDesc('id')
            ->paginate(20);

        return $this->response
            ->paginator($flows, new FlowTransformer())
            ->addMeta('balance', $this->user()->balance);
    }

    /**
     * @return mixed
     *
     * 提现列表
     */
    public function flowOutList()
    {
        $outs = FlowOut::select(['id', 'total_amount', 'created_at', 'status'])
            ->where('user_id', $this->user()->id)
            ->orderByDesc('id')
            ->get();

        return $this->response->array(['data' => $outs]);
    }

    public function flowOutStore(FlowOutRequest $request, FlowOut $flowOut)
    {
        $flowOut->fill($request->all());
    }
}
