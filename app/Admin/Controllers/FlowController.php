<?php

namespace App\Admin\Controllers;

use App\Models\FlowOut;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

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

        $grid->model()->orderByDesc('id');
        //禁用创建
        $grid->disableCreateButton();
        //禁用分页
//        $grid->disablePagination();
        //禁用检索
//        $grid->disableFilter();
        //禁用导出
        $grid->disableExport();
        //禁用多行
//        $grid->disableRowSelector();
//        $grid->disableColumnSelector();
        //禁用操作
        $grid->disableActions();

        $grid->actions(function ($actions) {

            // 去掉删除
//            $actions->disableDelete();

            // 去掉编辑
//            $actions->disableEdit();

            // 去掉查看
//            $actions->disableView();
        });

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
//            $filter->disableIdFilter();

            // 在这里添加字段过滤器


        });
        $grid->column('id', __('Id'));
        $grid->column('total_amount', __('总金额'));
        $grid->column('status', __('审核状态'))->switch();
        $grid->column('out_status', __('提现状态'))->display(function ($out_status) {
            if ($out_status == 1) {
                return '成功';
            }
            return '未提现';
        });
        $grid->column('out_method', __('提现方式'))->using([
            'wechat' => '微信',
            'alipay' => '支付宝'
        ]);
        $grid->column('ali_account', __('支付宝账号'));
        $grid->column('user_id', __('用户'))->display(function ($user_id) {
            return User::find($user_id)->nickname;
        })->expand(function ($model) {
            $user = $model->user;
            $extra = $user->extra()->select([
                'name', 'idcard', 'idcard', 'health', 'extra', 'created_at'
            ])->get();
            if ($extra->isNotEmpty()) {
                return new Table([
                    '姓名', '身份证号', '健康', '备注', '创建时间'
                ], $extra->toArray());
            }


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
