<?php

namespace App\Admin\Controllers;

use App\Models\FlowOut;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FlowController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '提现记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FlowOut);

        $grid->column('id', __('Id'));
        $grid->column('total_amount', __('总金额'));
        $grid->column('status', __('审核状态'))->using([
            '0' => '未审核',
            '1' => '已审核'
        ]);
        $grid->column('out_status', __('提现状态'))->using([
            '0' => '未提现',
            '1' => '已提现'
        ]);
        $grid->column('out_method', __('提现方式'))->using([
            'wechat' => '微信',
            'alipay' => '支付宝'
        ]);
        $grid->column('ali_account', __('阿里账号'));
        $grid->column('user_id', __('用户姓名'))->display(function ($user_id) {
            return User::find($user_id)->nickname;
        });
        $grid->column('created_at', __('创建时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(FlowOut::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('total_amount', __('Total amount'));
        $show->field('status', __('Status'));
        $show->field('out_status', __('Out status'));
        $show->field('out_method', __('Out method'));
        $show->field('ali_account', __('Ali account'));
        $show->field('user_id', __('User id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FlowOut);

//        $form->decimal('total_amount', __(''));
        $form->switch('status', __('审核状态'));
        $form->switch('out_status', __('Out status'));
        $form->text('out_method', __('Out method'));
        $form->text('ali_account', __('Ali account'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
