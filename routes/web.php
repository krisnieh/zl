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
    return view('welcome');
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// 微信
Route::get('/wechat/ca', 'WechatController@ca');
Route::post('/wechat/ca', 'WechatController@answer'); # post xml
Route::get('/wechat/menu/create', 'WechatController@menuCreate');
Route::get('/wechat/menu/delete', 'WechatController@menuDelete');
Route::get('/wechat/cut', 'UserController@cut');

// web登录
Route::get('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::post('/check', 'UserController@check');
Route::get('/register', 'UserController@register');
Route::post('/reg_check', 'UserController@regCheck');


Route::group(['middleware' => ['login', 'state']], function () {
    Route::get('/apps', function () {
        return view('apps');
    });

    // 用户
    Route::get('/users', 'UserController@index');
    Route::get('/lock/{id}', 'UserController@lock');
    Route::get('/unlock/{id}', 'UserController@unlock');
    Route::get('/ad', 'UserController@ad');

});


// -------- test ----------

Route::get('/t', 'WechatController@test');


Route::get('/test', function() {
    Cache::get(session('openid'));
    // $a = new Carbon\Carbon;
    // $b = $a->now()->addDays(1);

    // if($a->now()->gte($b)){
    //     echo "good";
    // }else{
    //     echo "fuck";
    // }

    // echo(json_decode(null));
});




















