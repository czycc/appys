<?php

namespace App\Admin\Controllers;

use App\Models\Teacher;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeachersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '教师管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Teacher);
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

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('姓名'));
        $grid->column('desc', __('描述'));
        $grid->column('video_url', __('视频简介'))->video(['videoWidth' => 720, 'videoHeight' => 480]);
        $grid->column('imgs', __('多图简介'))->carousel();
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
        $show = new Show(Teacher::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('desc', __('Desc'));
        $show->field('video_url', __('Video url'));
        $show->field('imgs', __('Imgs'));
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
        $form = new Form(new Teacher);

        $form->text('name', __('姓名'))->rules('required|string|between:2,20');
        $form->password('password', __('密码'))->rules('required|between:6,30');
        $form->textarea('desc', __('描述'));
        $form->text('video_url', __('视频链接'))->rules('required|active_url');
        $form->multipleImage('imgs', __('多图简介上传'))->removable();


        return $form;
    }
}
