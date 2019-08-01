<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Flow;
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

    public function flowOutList()
    {

    }
}
