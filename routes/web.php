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

Route::get('/', function() {
    return view('ok');
});


Route::get('/wechat/ca', 'WechatController@ca');
Route::get('/wechat/menu/create', 'WechatController@menuCreate');
Route::get('/wechat/menu/delete', 'WechatController@menuDelete');

// 登录
Route::get('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::post('/check', 'UserController@check');


Route::group(['middleware' => ['login', 'state']], function () {
    Route::get('/apps', function () {
        return view('apps');
    });

    // 用户
    Route::get('/users', 'UserController@index');
    Route::get('/lock/{id}', 'UserController@lock');
    Route::get('/unlock/{id}', 'UserController@unlock');
    Route::get('/home', 'UserController@home');

});

Route::get('/t', 'WechatController@test');


Route::get('/test', function() {
   return view('ok');
});