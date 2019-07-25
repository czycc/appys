<?php

namespace App\Admin\Controllers;

use App\Models\Configure;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ConfigureController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '平台设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new Configure);

        //禁用创建
        $grid->disableCreateButton();
        //禁用分页
        $grid->disablePagination();
        //禁用检索
        $grid->disableFilter();
        //禁用导出
        $grid->disableExport();
        //禁用多行
        $grid->disableRowSelector();
        $grid->disableColumnSelector();
        //禁用操作
        $grid->disableActions();

        $grid->column('distribute1_vip', __('购买会员一级分销比,百分比'));
        $grid->column('distribute2_vip', __('购买会员二级分销比,百分比'));
        $grid->column('distribute3_vip', __('购买会员三级分销比,百分比'));
        $grid->column('distribute1_course', __('购买课程一级分销比,百分比'));
        $grid->column('distribute2_course', __('购买课程二级分销比,百分比'));
        $grid->column('distribute3_course', __('购买课程三级分销比,百分比'));
        $grid->column('pub_plat', __('购买文章平台分成'));
        $grid->column('pub_self', __('购买文章自己分成'));
        $grid->column('vip2_price_n', __('银牌会员无上级购买价格'));
        $grid->column('vip2_price_y', __('银牌会员有上级购买价格'));
        $grid->column('vip3_price', __('代理价格,线下缴费'));
        $grid->column('invite_copper', __('邀请用户得铜币数'));
        $grid->column('zan_copper', __('点赞得铜币数	'));
        $grid->column('copper_pay_percent', __('铜币抵扣比例，百分比'));
        $grid->column('copper_pay_num', __('铜币兑换1元所需数量'));
        $grid->column('buy_vip2_self', __('购买银牌会员自己得银币'));
        $grid->column('buy_vip2_top_vip2', __('购买银牌会员上级是银牌会员得银币数'));
        $grid->column('buy_vip2_top_vip3', __('购买银牌会员上级是代理得金币数'));
        $grid->column('buy_vip3_top_vip2', __('购买代理上级是银牌得银币数'));
        $grid->column('buy_vip3_top_vip3', __('购买代理上级是代理得金币数'));

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
        $show = new Show(Configure::findOrFail($id));

//        $show->field('distributor1', __('购买会员一级分销比,百分比'));
//        $show->field('distributor2', __('二级分销比,百分比'));
//        $show->field('distributor3', __('三级分销比,百分比'));
//        $show->field('vip2_price_n', __('银牌会员无上级购买价格'));
//        $show->field('vip2_price_y', __('Vip2 price y'));
//        $show->field('vip3_price', __('Vip3 price'));
//        $show->field('invite_copper', __('Invite copper'));
//        $show->field('zan_copper', __('Zan copper'));
//        $show->field('copper_pay_percent', __('Copper pay percent'));
//        $show->field('copper_pay_num', __('Copper pay num'));
//        $show->field('buy_vip2_self', __('Buy vip2 self'));
//        $show->field('buy_vip2_top_vip2', __('Buy vip2 top vip2'));
//        $show->field('buy_vip2_top_vip3', __('Buy vip2 top vip3'));
//        $show->field('buy_vip3_top_vip2', __('Buy vip3 top vip2'));
//        $show->field('buy_vip3_top_vip3', __('Buy vip3 top vip3'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Configure);
        // 去掉`列表`按钮
        $form->tools(function (Form\Tools $tools) {

            // 去掉`列表`按钮
            $tools->disableList();

            // 去掉`删除`按钮
            $tools->disableDelete();

            // 去掉`查看`按钮
            $tools->disableView();

            // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
            $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;所有用户金银币归0</a>');

        });


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
        $distribute_rules = 'required|integer|min:0|max:100';
        $price = 'required|numeric|min:0.01';
        $num = 'required|integer|min:0';
        $form->number('distribute1_vip', __('购买会员一级分销比,百分比'))->rules($distribute_rules);
        $form->number('distribute2_vip', __('购买会员二级分销比,百分比'))->rules($distribute_rules);
        $form->number('distribute3_vip', __('购买会员三级分销比,百分比'))->rules($distribute_rules);
        $form->number('distribute1_course', __('购买课程一级分销比,百分比'))->rules($distribute_rules);
        $form->number('distribute2_course', __('购买课程二级分销比,百分比'))->rules($distribute_rules);
        $form->number('distribute3_course', __('购买课程三级分销比,百分比'))->rules($distribute_rules);
        $form->number('pub_plat', __('购买文章平台分成'))->rules($distribute_rules);
        $form->number('pub_self', __('购买文章自己分成'))->rules($distribute_rules);

        $form->decimal('vip2_price_n', __('银牌会员无上级购买价格'))->rules($price);
        $form->decimal('vip2_price_y', __('银牌会员有上级购买价格'))->rules($price);
        $form->decimal('vip3_price', __('代理价格,线下缴费'))->rules($price);
        $form->number('invite_copper', __('邀请用户得铜币数'))->rules($num);
        $form->number('zan_copper', __('点赞得铜币数'))->rules($num);
        $form->number('copper_pay_percent', __('铜币抵扣比例，百分比'))->rules($distribute_rules);
        $form->number('copper_pay_num', __('铜币兑换1元所需数量'))->rules($num);
        $form->number('buy_vip2_self', __('购买银牌会员自己得银币'))->rules($num);
        $form->number('buy_vip2_top_vip2', __('购买银牌会员上级是银牌会员得银币数'))->rules($num);
        $form->number('buy_vip2_top_vip3', __('购买银牌会员上级是代理得金币数'))->rules($num);
        $form->number('buy_vip3_top_vip2', __('购买代理上级是银牌得银币数'))->rules($num);
        $form->number('buy_vip3_top_vip3', __('购买代理上级是代理得金币数'))->rules($num);

        return $form;
    }
}
