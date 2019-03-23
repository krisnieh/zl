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

// web登录
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


// -------- test ----------

Route::get('/t', 'WechatController@test');


Route::get('/test', function() {
    $arr =[
           'OpenID' => '用户', 
           'Articles' => [
               ['title'=>'标题 1', 'description'=>'简介1', 'picurl'=>'图片1', 'url'=>'地址1'],
               ['title'=>'标题 1', 'description'=>'简介1', 'picurl'=>'图片1', 'url'=>'地址1'],
           ],
       ];

    $t = new App\Wechat\Answer;

    // $r = $t->news($arr);

    // echo($r);
    Log::info($t->router());

});




















