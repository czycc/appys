<?php

namespace App\Http\Controllers\Api\v1;

use App\Transformers\NotificationTransformer;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $list = $this->user()->notifications()->paginate(20);

        $this->user()->markAsRead();

        return $this->response->paginator($list, new NotificationTransformer());
    }
}
