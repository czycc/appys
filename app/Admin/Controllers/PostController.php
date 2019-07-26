<?php

namespace App\Admin\Controllers;

use App\Models\CompanyPost;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公司文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyPost);

        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('body', __('图文内容'));
        $grid->column('thumbnail', __('封面图'));
        $grid->column('media_type', __('媒体类型'));
        $grid->column('media_url', __('媒体链接'));
//        $grid->column('view_count', __(''));
        $grid->column('zan_count', __('点赞数量'))->sortable();
        $grid->column('order', __('权重'))->sortable();
        $grid->column('category_id', __('分类'))->display(function ($id) {

        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

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
        $show = new Show(CompanyPost::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('body', __('Body'));
        $show->field('thumbnail', __('Thumbnail'));
        $show->field('media_type', __('Media type'));
        $show->field('media_url', __('Media url'));
        $show->field('view_count', __('View count'));
        $show->field('zan_count', __('Zan count'));
        $show->field('order', __('Order'));
        $show->field('category_id', __('Category id'));
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
        $form = new Form(new CompanyPost);

        $form->text('title', __('Title'));
        $form->textarea('body', __('Body'));
        $form->textarea('thumbnail', __('Thumbnail'));
        $form->text('media_type', __('Media type'))->default('audio');
        $form->textarea('media_url', __('Media url'));
        $form->number('view_count', __('View count'));
        $form->number('zan_count', __('Zan count'));
        $form->number('order', __('Order'));
        $form->number('category_id', __('Category id'));

        return $form;
    }
}
