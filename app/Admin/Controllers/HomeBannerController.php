<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HomeBannerController extends AdminController
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

        $grid->column('id', __('Id'));
        $grid->column('img_url', __('轮播图'))->image();
        $grid->column('desc', __('描述'));
        $grid->column('type', __('跳转类型'))->using([
            'courses'  => '课程',
            'company_posts' => '公司文章'
        ]);
        $grid->column('type_id', __('对应id'));
        $grid->column('order', __('权重'));
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
        $form->cropper('img_url', __('轮播图(推荐1080 * 560)'))
            ->uniqueName();
        $form->textarea('desc', __('描述'));
        $form->select('type', __('跳转类型'))
            ->options([
                'courses' => '课程',
                'company_posts' => '公司文章'
            ])
            ->default('courses');
        $form->number('type_id', __('类型id'));
        $form->number('order', __('权重'));

        return $form;
    }
}
