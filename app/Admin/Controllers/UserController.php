<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

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
        $grid->disableRowSelector();
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
        $grid->quickSearch('phone')->placeholder('按手机号搜索');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('phone', __('手机号'));
        $grid->column('nickname', __('昵称'))->expand(function ($model) {
            $extra = $model->extra()->select([
                'name', 'idcard', 'idcard', 'health', 'extra', 'created_at'
            ])->get();
            if ($extra->isNotEmpty()) {
                return new Table([
                    '姓名', '身份证号', '健康', '备注', '创建时间'
                ], $extra->toArray());
            }

        });
        $grid->column('avatar', __('头像'))->image(80, 80);
        $grid->column('gold', __('金币'));
        $grid->column('silver', __('银币'));
        $grid->column('copper', __('铜币'));
        $grid->column('bound_id', __('上级'))->display(function ($boundId) {
            if ($boundId) {
                $user = User::find($boundId);
                return "<a href='admin_users?&id={$user->id}'>" . $user->nickname . "</a>";
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
        $form->saving(function (Form $form) {
            switch ($form->vip) {
                case '铜牌会员':
                    $form->vip = 0;
                    break;
                case '银牌会员':
                    $form->vip = 1;
                    break;
                case '代理会员':
                    $form->vip = 2;
                    break;
            }

        });
        $form->mobile('phone', __('手机'))->disable();
        $form->text('nickname', __('昵称'));
        $form->number('gold', __('金币'));
        $form->number('silver', __('银币'));
        $form->number('copper', __('铜币'));
        $form->select('vip', __('会员(必须同时设置到期时间)'))->options([
            '铜牌会员' => '铜牌会员',
            '银牌会员' => '银牌会员',
            '代理会员' => '代理会员',
        ])->required();
        $form->datetime('expire_at', __('到期时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
