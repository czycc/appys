<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Buynote extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '课程购买须知';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $note = \App\Models\Buynote::first();
        $note->body = $request->input('body');
        $note->save();
        admin_success('修改成功!.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->editor('body', '图文内容')->rules('required');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $note = \App\Models\Buynote::first();
        return [
            'body' => $note->body,
        ];
    }
}
