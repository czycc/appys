<?php

namespace App\Admin\Controllers;

use App\Models\ArticlePrice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticlePriceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章价格设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticlePrice);

        //禁用按钮
        $grid->disablePagination();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableColumnSelector();

        $grid->column('id', __('Id'));
        $grid->column('price', __('价格'));


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
        $show = new Show(ArticlePrice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('price', __('Price'));
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
        $form = new Form(new ArticlePrice);
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
        $form->decimal('price', __('价格'))->rules('required|numeric|min:0.00');

        return $form;
    }
}
