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

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
//            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('bound_id', '按上级用户id查询');
        });

        //快速查询
        $grid->quickSearch('phone')->placeholder('按手机号搜索');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('phone', __('手机号'))->filter('like');
        $grid->column('nickname', __('昵称'))->filter('like');
        $grid->column('avatar', __('头像'))->image(80, 80);
        $grid->column('gold', __('金币'))->sortable();
        $grid->column('silver', __('银币'))->sortable();
        $grid->column('copper', __('铜币'))->sortable();
        $grid->column('bound_id', __('上级'))->display(function ($boundId) {
            $status = '';
            if (!$this->bound_status) {
                $status = '(未确认)';
            }
            if ($boundId) {
                $user = User::find($boundId);
                return "<a href='admin_users?&id={$user->id}'>" . $user->nickname . $status . "</a>";
            }
        });
        $grid->column('vip', __('Vip'));
        $grid->column('expire_at', __('到期'))->filter('range', 'datetime');
        $grid->column('balance', __('收益'))->sortable();
        $grid->column('created_at', __('创建'))->filter('range', 'datetime');

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
