<?php

namespace App\Admin\Controllers;

use App\Models\CompanyCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公司文章分类';

    /**
     * Make a grid builder.
     *
     * @return Grid【
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyCategory);

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
            $actions->disableDelete();

            // 去掉编辑
//            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('名称'));
//        $grid->column('parent_id', __('Parent id'));
//        $grid->column('level', __('Level'));
//        $grid->column('is_directory', __('Is directory'));
        $grid->column('desc', __('Desc'));
//        $grid->column('post_count', __('Post count'));

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
        $show = new Show(CompanyCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('parent_id', __('Parent id'));
        $show->field('level', __('Level'));
        $show->field('is_directory', __('Is directory'));
        $show->field('desc', __('Desc'));
        $show->field('post_count', __('Post count'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CompanyCategory);

        $form->footer(function ($footer) {

            // 去掉`重置`按钮
//            $footer->disableReset();

            // 去掉`提交`按钮
//            $footer->disableSubmit();

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        $form->tools(function (Form\Tools $tools) {

            // 去掉`列表`按钮
//            $tools->disableList();

            // 去掉`删除`按钮
            $tools->disableDelete();

            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->text('name', __('名称'));
//        $form->number('parent_id', __('Parent id'));
//        $form->number('level', __('Level'));
//        $form->switch('is_directory', __('Is directory'));
        $form->text('desc', __('描述'));
//        $form->number('post_count', __('Post count'));

        return $form;
    }
}
