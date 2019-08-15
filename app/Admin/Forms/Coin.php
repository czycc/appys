<?php

namespace App\Admin\Forms;

use Carbon\Carbon;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Coin extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '重置金币银币';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        if ($request->reset === 'on') {
            Redis::set('last_reset_date', Carbon::now()->toDateTimeString());
            DB::table('users')->update([
                'silver' => 0,
                'gold' => 0
            ]);
            admin_success('重置成功' . $request->reset);
        } else {
            admin_info('无操作');
        }
        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->switch('reset', '是否重置')->states([
            'on'  => ['value' => 1, 'text' => '重置', 'color' => 'danger'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'success'],
        ]);
        $this->datetime('date', '上次重置时间')->disable();
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'reset' => 0,
            'date' => Redis::get('last_reset_date')
        ];
    }
}
