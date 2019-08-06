<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return view('welcome');
});

Route::get('alipay', function () {
    $order = [
        'out_trade_no' => '20190806154635757937',
        'total_amount' => '2.00',
        'subject' => '购买 银牌会员',
    ];

    return \Pay::alipay()->web($order);
});

Route::get('course/{course_id}/user/{user_id}', function () {
    return '分享成功';
});