<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Teacher;
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

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
//            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('teacher.name', '按教师名');
            $filter->like('title', '按标题');

        });
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('banner', __('大图'))->image('', 100, 100);
        $grid->column('ori_price', __('原价'));
        $grid->column('now_price', __('现价'));
        $grid->column('body', __('图文'))->display(function ($body) {
            return make_excerpt($body, 15);
        });
//        $grid->column('view_count', __(''));
        $grid->column('zan_count', __('赞数'))->sortable();
        $grid->column('buy_count', __('购买次数'))->sortable();
        $grid->column('show', __('是否显示'))->using([
            '0' => '否',
            '1' => '是'
        ]);
        $grid->column('recommend', __('是否推荐'))->using([
            '0' => '否',
            '1' => '是'
        ]);
        $grid->column('order', __('权重'))->sortable();
        $grid->column('teacher.name', __('教师'));
        $grid->column('category.name', __('类别'));
        $grid->column('created_at', __('创建'));
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

            // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
//            $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
        });

        $form->text('title', __('标题'));
        $form->cropper('banner', __('封面图'))
            ->move('backend/images/courses/' . date('Ym/d', time()))
            ->uniqueName()->rules('required');
        $form->decimal('ori_price', __('原价'))->default(0.00);
        $form->decimal('now_price', __('现价'))->default(0.00);
        $form->editor('body', __('图文'));
//        $form->number('view_count', __('View count'));
        $form->number('zan_count', __('点赞数量'))->default(0);
//        $form->number('buy_count', __(''));
        $form->switch('show', __('是否显示'))->default(1);
        $form->switch('recommend', __('推荐'))->default(0);
        $form->number('order', __('权重'))->default(0);
//        $form->number('buynote_id', __('Buynote id'))->default(1);
        $form->select('teacher_id', __('教师（输入教师名搜索）'))->options(function ($id) {
            $teacher = Teacher::find($id);
            if ($teacher) {
                return [$teacher->id=> $teacher->name];
            }
        })->required()->ajax('/admin/api/teachers');
        $category = CourseCategory::all()->toArray();
        $category = array_pluck($category, 'name', 'id');
        $form->select('category_id', __('分类'))->options($category)->required();

        return $form;
    }
}
