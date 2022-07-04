<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/', 'App\Http\Controllers\Api\UserController@index')->name('api.index');

Route::prefix('v1')->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\UserController@index')->name('api.v1.index');

    Route::prefix('auth')->group(function () {
        Route::post('/get-token', 'App\Http\Controllers\Api\AuthController@get_token')->name('api.auth.token.index');
    });
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/request/{param}/{options}', 'App\Http\Controllers\Api\Generator\RestapiController@__get_fnc')->name('api.generator.get');
        Route::post('/request/{param}/{options}', 'App\Http\Controllers\Api\Generator\RestapiController@__post_fnc')->name('api.generator.post');
    });
});
