<?php

namespace App\Admin\Controllers;

use App\Models\FlowOut;
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
    protected $title = 'App\Models\FlowOut';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FlowOut);

        $grid->column('id', __('Id'));
        $grid->column('total_amount', __('Total amount'));
        $grid->column('status', __('Status'));
        $grid->column('out_status', __('Out status'));
        $grid->column('out_method', __('Out method'));
        $grid->column('ali_account', __('Ali account'));
        $grid->column('user_id', __('User id'));
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

        $form->decimal('total_amount', __('Total amount'));
        $form->switch('status', __('Status'));
        $form->switch('out_status', __('Out status'));
        $form->text('out_method', __('Out method'));
        $form->text('ali_account', __('Ali account'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}