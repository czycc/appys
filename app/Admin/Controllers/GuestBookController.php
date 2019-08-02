<?php

namespace App\Admin\Controllers;

use App\Models\GuestBook;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GuestBookController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '留言管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GuestBook);

        $grid->model()->orderByDesc('id');
        //禁用创建
        $grid->disableCreateButton();
        //禁用分页
//        $grid->disablePagination();
        //禁用检索
        $grid->disableFilter();
        //禁用导出
        $grid->disableExport();
        //禁用多行
//        $grid->disableRowSelector();
//        $grid->disableColumnSelector();
        //禁用操作
//        $grid->disableActions();

        $grid->actions(function ($actions) {

            // 去掉删除
//            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });

        $grid->column('id', __('Id'));
        $grid->column('body', __('内容'));
        $grid->column('user_id', __('店铺所属用户'))->display(function ($user_id) {
            return "<a href='/admin/admin_users?&id={$user_id}'>{$this->user->nickname}</a>";
        });
        $grid->column('guest_id', __('留言人'))->display(function ($guest_id) {
            return "<a href='/admin/admin_users?&id={$guest_id}'>{$this->guest->nickname}</a>";
        });
        $grid->column('guest_book_id', __('留言回复'))->display(function ($guest_book_id) {
            if ($guest_book_id) {
                return "@ <a href='/admin/admin_guest_books?&id={$guest_book_id}'>{$guest_book_id}</a>";
            }
            return '';
        });
        $grid->column('created_at', __('Created at'));

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
        $show = new Show(GuestBook::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('body', __('Body'));
        $show->field('user_id', __('User id'));
        $show->field('guest_id', __('Guest id'));
        $show->field('guest_book_id', __('Guest book id'));
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
        $form = new Form(new GuestBook);

        $form->textarea('body', __('Body'));
        $form->number('user_id', __('User id'));
        $form->number('guest_id', __('Guest id'));
        $form->number('guest_book_id', __('Guest book id'));

        return $form;
    }
}
