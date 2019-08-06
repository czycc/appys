<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CourseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '平台课程';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Course);

        $grid->model()->orderByDesc('id');
        //禁用创建
//        $grid->disableCreateButton();
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
//        $grid->disableActions();

        $grid->actions(function ($actions) {

            // 去掉删除
//            $actions->disableDelete();

            // 去掉编辑
//            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('banner', __('大图'));
        $grid->column('ori_price', __('原价'));
        $grid->column('now_price', __('现价'));
        $grid->column('body', __('图文'))->display(function ($body) {
            return make_excerpt($body, 15);
        });
//        $grid->column('view_count', __(''));
        $grid->column('zan_count', __('赞数'));
        $grid->column('buy_count', __('购买次数'));
        $grid->column('show', __('是否显示'));
        $grid->column('recommend', __('是否推荐'));
        $grid->column('order', __('权重'));
        $grid->column('teacher_id', __('Teacher id'));
        $grid->column('category_id', __('Category id'));
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
        $show = new Show(Course::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('banner', __('Banner'));
        $show->field('ori_price', __('Ori price'));
        $show->field('now_price', __('Now price'));
        $show->field('body', __('Body'));
        $show->field('view_count', __('View count'));
        $show->field('zan_count', __('Zan count'));
        $show->field('buy_count', __('Buy count'));
        $show->field('show', __('Show'));
        $show->field('recommend', __('Recommend'));
        $show->field('order', __('Order'));
        $show->field('buynote_id', __('Buynote id'));
        $show->field('teacher_id', __('Teacher id'));
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
        $form = new Form(new Course);

        $form->text('title', __('Title'));
        $form->textarea('banner', __('Banner'));
        $form->decimal('ori_price', __('Ori price'))->default(0.00);
        $form->decimal('now_price', __('Now price'))->default(0.00);
        $form->textarea('body', __('Body'));
        $form->number('view_count', __('View count'));
        $form->number('zan_count', __('Zan count'));
        $form->number('buy_count', __('Buy count'));
        $form->switch('show', __('Show'))->default(1);
        $form->switch('recommend', __('Recommend'));
        $form->number('order', __('Order'));
        $form->number('buynote_id', __('Buynote id'))->default(1);
        $form->number('teacher_id', __('Teacher id'));
        $form->number('category_id', __('Category id'));

        return $form;
    }
}
