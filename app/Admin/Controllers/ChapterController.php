<?php

namespace App\Admin\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use http\Client\Curl\User;

class ChapterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '章节管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Chapter);
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
        $grid->disableRowSelector();
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


        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
//            $filter->disableIdFilter();

            // 在这里添加字段过滤器


        });
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('标题'))->filter('like');
        $grid->column('price', __('价格'))->sortable();
//        $grid->column('media_type', __('媒体类型'));
        $grid->column('media_url', __('媒体链接'))->display(function ($media_url, $column) {
            if (!$this->media_url) {
                return '';
            }
            if ($this->media_type == 'video') {
                return $column->video(['videoWidth' => 720, 'videoHeight' => 480]);
            }
            return $column->audio(['audioWidth' => 240]);
        })->width(100);
        $grid->column('course_id', __('所属课程'))->display(function ($course_id) {
            $course = Course::find($course_id);
            if ($course) {
                return "<a href='admin_courses?id={$course->id}'>{$course->title}</a>";
            }
            return '';
        });
        $grid->column('order', __('权重'))->sortable();
        $grid->column('created_at', __('创建'));

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
        $show = new Show(Chapter::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('price', __('Price'));
        $show->field('media_type', __('Media type'));
        $show->field('media_url', __('Media url'));
        $show->field('course_id', __('Course id'));
        $show->field('order', __('Order'));
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
        $form = new Form(new Chapter);

        $form->text('title', __('标题'))->required();
        $form->decimal('price', __('价格'))->default(0.00);
        $form->select('media_type', __('媒体类型'))->options([
            'audio' => '音频',
            'video' => '视频'
        ])->required();
        $form->textarea('media_url', __('媒体链接'));
        $form->select('course_id', __('所属课程(输入课程名称搜索)'))->options(function ($id) {
            $course = Course::find($id);
            if ($course) {
                return [$course->id => $course->title];
            }
        })->required()->ajax('/admin/api/courses');
        $form->number('order', __('权重'));

        return $form;
    }
}
