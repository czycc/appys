<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        //禁用创建
        $grid->disableCreateButton();
        //禁用分页
//        $grid->disablePagination();
        //禁用检索
//        $grid->disableFilter();
        //禁用导出
        $grid->disableExport();
        //禁用多行
        $grid->disableRowSelector();
//        $grid->disableColumnSelector();
        //禁用操作
//        $grid->disableActions();

        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();

            // 去掉查看
//            $actions->disableView();
        });


        $grid->filter(function($filter){

            // 去掉默认的id过滤器
//            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('no', '按订单号');
            $filter->between('paid_at', '按支付时间')->dateTime();
            $filter->in('pay_method', '支付时间')->multipleSelect([
                'alipay' => '支付宝',
                'wechat' => '微信'
            ]);

        });


        $grid->model()->where('closed', 0)
            ->whereNotNull('paid_at')
            ->orderByDesc('id');

        $grid->column('id', __('Id'))->sortable()->totalRow('合计');
        $grid->column('title', __('标题'));
        $grid->column('user_id', __('用户'))->display(function ($userId) {
            $user = User::find($userId);
            return "<a href='admin_users?&id={$user->id}'>" . $user->nickname . "</a>";
        });
        $grid->column('no', __('订单号'));
        $grid->column('total_amount', __('实付金额'))->totalRow();
        $grid->column('deduction', __('抵扣金额'))->totalRow();
        $grid->column('paid_at', __('支付时间'))->sortable();
        $grid->column('pay_method', __('支付方式'))->sortable();
        $grid->column('pay_no', __('平台订单'));
//        $grid->column('closed', __('关闭状态'));
        $grid->column('type', __('购买类型'))->using([
            'audio' => '用户音频',
            'video' => '用户视频',
            'topic' => '用户文章',
            'course' => '平台课程',
            'vip' => '会员'
        ])->filter([
            'audio' => '用户音频',
            'video' => '用户视频',
            'topic' => '用户文章',
            'course' => '平台课程',
            'vip' => '会员'
        ]);
//        $grid->column('type_id', __('Type id'));
        $grid->column('extra', __('备注'));
        $grid->column('created_at', __('创建'))->filter('range', 'datetime');
//        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('user_id', __('User id'));
        $show->field('no', __('No'));
        $show->field('total_amount', __('Total amount'));
        $show->field('deduction', __('Deduction'));
        $show->field('paid_at', __('Paid at'));
        $show->field('pay_method', __('Pay method'));
        $show->field('pay_no', __('Pay no'));
        $show->field('closed', __('Closed'));
        $show->field('type', __('Type'));
        $show->field('type_id', __('Type id'));
        $show->field('extra', __('Extra'));
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
        $form = new Form(new Order);

        $form->text('title', __('标题'));
        $form->number('user_id', __(''));
        $form->text('no', __('No'));
        $form->decimal('total_amount', __('Total amount'));
        $form->decimal('deduction', __('Deduction'))->default(0.00);
        $form->datetime('paid_at', __('Paid at'))->default(date('Y-m-d H:i:s'));
        $form->text('pay_method', __('Pay method'));
        $form->text('pay_no', __('Pay no'));
        $form->switch('closed', __('Closed'));
        $form->text('type', __('Type'));
        $form->number('type_id', __('Type id'));
        $form->text('extra', __('Extra'));

        return $form;
    }
}
