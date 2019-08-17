<?php

namespace App\Admin\Controllers;

use App\Models\CompanyCategory;
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
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('body', __('图文内容'))->display(function ($body) {
            return make_excerpt($body, 30);
        });
        $grid->column('thumbnail', __('封面图'))->image(100, 100);
        $grid->column('media_type', __('媒体类型'))->using(['video' => '视频', 'audio' => '音频']);
        $grid->column('media_url', __('媒体链接'))->display(function ($media_url, $column) {
            if (!$this->media_url) {
                return '';
            }
            if ($this->media_type == 'video') {
                return $column->video(['videoWidth' => 720, 'videoHeight' => 480]);
            }
            return $column->audio(['audioWidth' => 240]);
        })->width(100);
//        $grid->column('view_count', __(''));
        $grid->column('zan_count', __('点赞数量'))->sortable();
        $grid->column('order', __('权重'))->sortable();
        $grid->column('category.name', __('分类'));
        $grid->column('created_at', __('创建时间'));
//        $grid->column('updated_at', __('更新时间'));

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
//            $tools->disableDelete();

            // 去掉`查看`按钮
            $tools->disableView();

            // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
//            $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
        });

        $date = date('Ym/d', time());
        $form->text('title', __('标题'));
        $form->editor('body', __('内容(图片10M以内)'));
        $form->cropper('thumbnail', __('封面图(必传)'))
            ->move('backend/images/posts/' . $date)
            ->uniqueName()->rules('required');
        $form->select('media_type', __('媒体类型'))->options([
            'audio' => '音频',
            'video' => '视频'
        ])->required();
        $form->text('media_url', __('媒体链接'));
//        $form->number('view_count', __(''));
        $form->number('zan_count', __('点赞数量'))->default(0);
        $form->number('order', __('权重'))->default(0)->required();
        $category = CompanyCategory::all()->toArray();
        $category = array_pluck($category, 'name', 'id');
        $form->select('category_id', __('分类'))->options($category)->required();

        return $form;
    }
}
