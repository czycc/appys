<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class Index extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '首页设置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        Redis::set('appys_index_notify', json_encode($request->input('notify')['values']));
        admin_success('操作成功～');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->list('notify', '首页小喇叭通知信息')->rules('required|min:2');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $notify = Redis::get('appys_index_notify');

        return [
            'notify' => json_decode($notify, true)
        ];
    }
}
