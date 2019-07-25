<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '首页轮播图';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);

        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableColumnSelector();

        $grid->column('id', __('Id'));
        $grid->column('img_url', __('图片'))->image();
        $grid->column('desc', __('描述'));
        $grid->column('type', __('跳转类型'))->using([
            'courses' => '课程',
            'company_posts' => '公司文章'
        ]);
        $grid->column('type_id', __('跳转id'));
        $grid->column('order', __('权重'));
        $grid->column('updated_at', __('修改时间'));

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
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('img_url', __('Img url'));
        $show->field('desc', __('Desc'));
        $show->field('type', __('Type'));
        $show->field('type_id', __('Type id'));
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
        $form = new Form(new Banner);

        $form->image('img_url', __('图片'));
        $form->textarea('desc', __('描述'));
        $form->select('type', __('跳转类型'))
            ->options([
                'courses' => '课程',
                'company_posts' => '公司文章'
            ])
            ->default('courses');
        $form->number('type_id', __('对应id'));
        $form->number('order', __('权重'));

        return $form;
    }
}
