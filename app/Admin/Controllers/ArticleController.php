<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户作品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);

        $grid->model()->orderByDesc('id');
        //禁用创建
        $grid->disableCreateButton();
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
            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
//            $filter->disableIdFilter();

            // 在这里添加字段过滤器


        });
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('top_img', __('大图'))->image('');
        $grid->column('body', __('图文'))->display(function ($body) {
            return make_excerpt($body, 10);
        });
        $grid->column('media_type', __('媒体类型'))->using(['video' => '视频', 'audio' => '音频'])->hide();
        $grid->column('media_url', __('媒体链接'))->display(function ($media_url, $column) {
            if (!$this->media_url) {
                return '';
            }
            if ($this->media_type == 'video') {
                return $column->video(['videoWidth' => 720, 'videoHeight' => 480]);
            }
            return $column->audio(['audioWidth' => 240]);
        })->width(100);
        $grid->column('multi_imgs', __('多图'))->carousel(150,150)->hide();
        $grid->column('price', __('价格'))->editable();
        $grid->column('zan_count', __('赞数'));
        $grid->column('user.nickname', __('用户'));
        $grid->column('status', __('审核'))->switch();
        $grid->column('created_at', __('创建'))->hide();

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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('top_img', __('Top img'));
        $show->field('body', __('Body'));
        $show->field('media_type', __('Media type'));
        $show->field('media_url', __('Media url'));
        $show->field('multi_imgs', __('Multi imgs'));
        $show->field('price', __('Price'));
        $show->field('zan_count', __('Zan count'));
        $show->field('user_id', __('User id'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Article);

        $form->text('title', __('Title'));
        $form->textarea('top_img', __('Top img'));
        $form->textarea('body', __('Body'));
        $form->text('media_type', __('Media type'));
        $form->textarea('media_url', __('Media url'));
        $form->text('multi_imgs', __('Multi imgs'));
        $form->decimal('price', __('Price'))->default(0.00);
        $form->number('zan_count', __('Zan count'));
        $form->number('user_id', __('User id'));
        $form->switch('status', __('Status'))->default(2);

        return $form;
    }
}
