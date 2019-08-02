<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '店铺管理哦';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Shop);

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
            $actions->disableDelete();

            // 去掉编辑
//            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('shop_phone', __('手机'));
        $grid->column('real_name', __('姓名'));
        $grid->column('introduction', __('介绍'));
        $grid->column('banner', __('大图'))->image('');
//        $grid->column('idcard', __('身份证'))->image();
//        $grid->column('license', __('营业执照'))->image();
//        $grid->column('shop_imgs', __('多图'))->carousel();
        $grid->column('status', __('审核'));
        $grid->column('recommend', __('推荐'));
        $grid->column('province', __('Province'));
        $grid->column('city', __('City'));
        $grid->column('district', __('District'));
        $grid->column('address', __('地址'));
//        $grid->column('wechat_qrcode', __('微信码'))->image('',80, 80);
        $grid->column('zan_count', __('赞'));
        $grid->column('order', __('权重'));
        $grid->column('user.nickname', __('所属人'));
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
        $show = new Show(Shop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('shop_phone', __('Shop phone'));
        $show->field('real_name', __('Real name'));
        $show->field('introduction', __('Introduction'));
        $show->field('banner', __('Banner'));
        $show->field('idcard', __('Idcard'));
        $show->field('license', __('License'));
        $show->field('shop_imgs', __('Shop imgs'));
        $show->field('longitude', __('Longitude'));
        $show->field('latitude', __('Latitude'));
        $show->field('status', __('Status'));
        $show->field('expire_at', __('Expire at'));
        $show->field('recommend', __('Recommend'));
        $show->field('province', __('Province'));
        $show->field('city', __('City'));
        $show->field('district', __('District'));
        $show->field('address', __('Address'));
        $show->field('wechat_qrcode', __('Wechat qrcode'));
        $show->field('zan_count', __('Zan count'));
        $show->field('order', __('Order'));
        $show->field('user_id', __('User id'));
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
        $form = new Form(new Shop);

//        $form->text('shop_phone', __('Shop phone'));
//        $form->text('real_name', __('Real name'));
//        $form->textarea('introduction', __('Introduction'));
//        $form->text('banner', __('Banner'));
//        $form->text('idcard', __('Idcard'));
//        $form->text('license', __('License'));
//        $form->text('shop_imgs', __('Shop imgs'));
//        $form->decimal('longitude', __('Longitude'));
//        $form->decimal('latitude', __('Latitude'));
        $form->switch('status', __('Status'))->default(2);
        $form->datetime('expire_at', __('Expire at'))->default(date('Y-m-d H:i:s'));
        $form->switch('recommend', __('Recommend'));
        $form->text('province', __('Province'));
        $form->text('city', __('City'));
        $form->text('district', __('District'));
        $form->text('address', __('Address'));
        $form->text('wechat_qrcode', __('Wechat qrcode'));
        $form->number('zan_count', __('Zan count'));
        $form->number('order', __('Order'));
        $form->number('user_id', __('User id'));

        return $form;
    }
}
