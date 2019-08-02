<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->model()->orderBy('id', 'desc');

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

        //快速查询
        $grid->quickSearch('phone');

        $grid->column('id', __('Id'));
        $grid->column('phone', __('手机号'));
        $grid->column('nickname', __('昵称'));
        $grid->column('avatar', __('头像'))->image(80, 80);
        $grid->column('gold', __('金币'));
        $grid->column('silver', __('银币'));
        $grid->column('copper', __('铜币'));
        $grid->column('bound_id', __('上级'))->display(function ($bound_id) {
            if ($bound_id) {
                return User::find($bound_id)->nickname;
            }
        });
        $grid->column('vip', __('Vip'));
        $grid->column('expire_at', __('到期'));
        $grid->column('balance', __('收益'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('phone', __('手机'));
        $show->field('nickname', __('昵称'));
        $show->field('avatar', __('Avatar'));
        $show->field('wx_openid', __('Wx openid'));
        $show->field('wx_unionid', __('Wx unionid'));
        $show->field('gold', __('Gold'));
        $show->field('silver', __('Silver'));
        $show->field('copper', __('Copper'));
        $show->field('notification_count', __('Notification count'));
        $show->field('bound_id', __('Bound id'));
        $show->field('bound_status', __('Bound status'));
        $show->field('vip', __('Vip'));
        $show->field('expire_at', __('Expire at'));
        $show->field('balance', __('Balance'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User);

        $form->mobile('phone', __('手机'))->disable();
        $form->text('nickname', __('昵称'))->disable();
        $form->number('gold', __('金币'));
        $form->number('silver', __('银币'));
        $form->number('copper', __('铜币'));
        $form->switch('vip', __('会员'));
        $form->datetime('expire_at', __('到期时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
