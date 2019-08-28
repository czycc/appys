<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户评论管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment);

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

        $grid->column('id', __('Id'))->sortable();
        $grid->column('article_id', __('文章'))->display(function ($article_id) {
            if ($this->article) {
                return "<a href='/admin/admin_articles?&id={$article_id}'>{$this->article->title}</a>";
            }else {
                return '';
            }
        });
        $grid->column('user_id', __('用户'))->display(function ($user_id) {
            if ($this->user) {
                return "<a href='/admin/admin_users?&id={$user_id}'>{$this->user->nickname}</a>";
            }
            return '';
        });
        $grid->column('content', __('内容'));
        $grid->column('created_at', __('创建'))->filter('range', 'datetime');

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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('article_id', __('Article id'));
        $show->field('user_id', __('User id'));
        $show->field('content', __('Content'));
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
        $form = new Form(new Comment);

//        $form->number('article_id', __('Article id'));
//        $form->number('user_id', __('User id'));
//        $form->textarea('content', __('Content'));

        return $form;
    }
}
