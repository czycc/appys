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

//editor 上传图片
Route::post('editor/upload', 'EditorUploadImgController@upload');

Route::get('type/{type}/id/{id}/user/{user_id}', 'ShareController@share');

Route::get('admin/api/courses', 'AdminApiController@courses');
Route::get('admin/api/teachers', 'AdminApiController@teachers');

Route::get('teacher', 'AdminTeacherController@index');
Route::post('teacher/login', 'AdminTeacherController@login');
Route::get('teacher/logout', 'AdminTeacherController@logout');