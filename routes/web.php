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
Route::get('/reg_cancel', 'UserController@regCancel');


Route::group(['middleware' => ['login', 'state']], function () {
    Route::get('/apps', function () {
        return view('apps');
    });

    // 业务
    Route::get('/pass', 'BizController@pass');

    // 用户
    Route::get('/ad', 'UserController@new');
    Route::get('/ad/{key}', 'UserController@ad');

    Route::get('/users', 'UserController@index');
    Route::get('/user/{id?}', 'UserController@show');
    Route::get('/user/lock/{id}', 'UserController@lock');
    Route::get('/user/unlock/{id}', 'UserController@unlock');
    Route::get('/user/{id}/{key}', 'UserController@set');

    // 机构
    Route::get('/orgs', 'OrgController@index');
    Route::get('/orgs/{id}', 'OrgController@show');
    Route::get('/org/lock/{id}', 'OrgController@lock');
    Route::get('/org/unlock/{id}', 'OrgController@unlock');

});


// -------- test ----------

Route::get('/t', 'OrgController@test');


Route::get('/test', function() {
    $str = 'a_b_c';
    $arr = explode('_', $str);
    $do = end($arr);
        return $do;
    // $a = Auth::user()->org->typeConf->order;

    // echo $a;

// // abort('500');
//     $a = new App\Helpers\Role;

//     if ($a->staff()) {
//         echo "good";
//     }else{
//         echo "fuck";
//     }

});




















