<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Configure extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '配置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $configure = \App\Models\Configure::first();
        $configure->update($request->all());

        admin_success('修改成功');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $distribute_rules = 'required|integer|min:0|max:100';
        $price = 'required|numeric|min:0.01';
        $num = 'required|integer|min:0';
        $this->number('distribute1_vip', __('购买会员一级分销比,百分比'))->rules($distribute_rules);
        $this->number('distribute2_vip', __('购买会员二级分销比,百分比'))->rules($distribute_rules);
        $this->number('distribute3_vip', __('购买会员三级分销比,百分比'))->rules($distribute_rules);
        $this->number('distribute1_course', __('购买课程一级分销比,百分比'))->rules($distribute_rules);
        $this->number('distribute2_course', __('购买课程二级分销比,百分比'))->rules($distribute_rules);
        $this->number('distribute3_course', __('购买课程三级分销比,百分比'))->rules($distribute_rules);
//        $this->number('pub_plat', __('购买文章平台分成'))->rules($distribute_rules);
        $this->number('pub_self', __('购买文章用户自己分成'))->rules($distribute_rules);

        $this->decimal('vip2_price_n', __('购买银牌会员无上级价格'))->rules($price);
        $this->decimal('vip2_price_y', __('购买银牌会员有上级价格'))->rules($price);
        $this->decimal('vip3_price', __('代理价格,线下缴费'))->rules($price);
        $this->number('invite_copper', __('邀请用户得铜币数'))->rules($num);
        $this->number('zan_copper', __('点赞得铜币数'))->rules($num);
        $this->number('copper_pay_percent', __('铜币抵扣比例，百分比'))->rules($distribute_rules);
        $this->number('copper_pay_num', __('铜币兑换1元所需数量'))->rules($num);
        $this->number('buy_vip2_self', __('购买银牌会员自己得银币'))->rules($num);
        $this->number('buy_vip2_top_vip2', __('购买银牌会员上级是银牌会员得银币数'))->rules($num);
        $this->number('buy_vip2_top_vip3', __('购买银牌会员上级是代理得金币数'))->rules($num);
        $this->number('buy_vip3_top_vip2', __('购买代理上级是银牌得银币数'))->rules($num);
        $this->number('buy_vip3_top_vip3', __('购买代理上级是代理得金币数'))->rules($num);

    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {

        return \App\Models\Configure::first()->toArray();
    }
}
