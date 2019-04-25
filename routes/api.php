<?php

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

Route::post('login', 'Auth\LoginController@api_login');
Route::post('register', 'Auth\RegisterController@api_register');
Route::post('register-driver', 'Auth\RegisterController@register_driver');

Route::group(['middleware' => 'auth:api'], function () {
    //tow truck drivers
   
});
