<?php

namespace App\Admin\Controllers;

use App\Models\Order;
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
    protected $title = 'App\Models\Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('user_id', __('User id'));
        $grid->column('no', __('No'));
        $grid->column('total_amount', __('Total amount'));
        $grid->column('deduction', __('Deduction'));
        $grid->column('paid_at', __('Paid at'));
        $grid->column('pay_method', __('Pay method'));
        $grid->column('pay_no', __('Pay no'));
        $grid->column('closed', __('Closed'));
        $grid->column('type', __('Type'));
        $grid->column('type_id', __('Type id'));
        $grid->column('extra', __('Extra'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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

        $form->text('title', __('Title'));
        $form->number('user_id', __('User id'));
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
