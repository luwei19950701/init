<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// API版本分组
Route::group(['prefix' => 'v1'], function () {
    // 模块分组
    Route::group(['prefix' => 'auth'], function () {
        // 创建access token
        Route::post('token', 'AuthController@token');
        // 更新access token
        Route::patch('token', 'AuthController@refreshToken');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        // 以下模块放置需要身份授权的接口
        // 注销access token
        Route::delete('auth/token', 'AuthController@revokeToken');

        Route::group(['prefix' => 'user'], function () {
            // 测试接口，用户获取登录用户基本信息
            Route::get('/info', function () {
                return \EcareYu\Services\UtilService::response('读取成功', Auth::user());
            });
        });
    });
});


