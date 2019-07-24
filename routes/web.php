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
   return 'true';
});

Route::get('alipay', function () {
    $order = [
        'out_trade_no' => time(),
        'total_amount' => '10000',
        'subject' => 'test subject - 测试',
    ];

    return \Pay::alipay()->web($order);
});