<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;

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
Route::middleware(['auth'])->group(function ($e) {

    Route::get('/', function () {
        return redirect('/extraweb/login');
    });

    /*
     * 
     * extraweb routes start here
     * 
     */
    Route::group(['prefix' => 'extraweb'], function ($e) {
        Route::get('/', 'App\Http\Controllers\Backend\AuthController@login')->name('extraweb.login');
        Route::get('/login', 'App\Http\Controllers\Backend\AuthController@login')->name('extraweb.login');
        Route::get('/logout', 'App\Http\Controllers\Backend\AuthController@logout')->name('extraweb.logout');

        Route::get('/forgot-password', 'App\Http\Controllers\Backend\AuthController@forgot_password')->name('extraweb.forgot_password');
        Route::get('/register', 'App\Http\Controllers\Backend\AuthController@register')->name('extraweb.register');

        Route::post('/validate-user', function (Request $request) {
            return Authenticate::validate_user($request);
        })->name('extraweb.validate');
        Route::post('/save-token', function (Request $request) {
            return Authenticate::save_token($request);
        })->name('extraweb.save_token');

        Route::get('/dashboard', 'App\Http\Controllers\Backend\AuthController@dashboard')->name('extraweb.dashboard');

        Route::prefix('profile')->group(function () {
            Route::get('/', 'App\Http\Controllers\Backend\AuthController@profile')->name('extraweb.profile');
            Route::get('/update', 'App\Http\Controllers\Backend\AuthController@update_profile')->name('extraweb.profile_update');
            Route::post('/update', 'App\Http\Controllers\Backend\AuthController@submit_update_profile')->name('extraweb.profile_update');
            Route::post('/upload_photo', 'App\Http\Controllers\Backend\AuthController@fnUploadPhoto')->name('extraweb.fnUploadPhoto');
            Route::post('/get-group-permission-list', 'App\Http\Controllers\Backend\AuthController@get_group_permission_list')->name('extraweb.get-group-permission-list');
        });

        Route::prefix('ajax')->group(function () {
            Route::get('/get/{method}', 'App\Http\Controllers\Globals\AjaxController@fn_ajax_get')->name('global.ajax_get');
            Route::post('/post/{method}', 'App\Http\Controllers\Globals\AjaxController@fn_ajax_post')->name('global.ajax_post');
        });

        Route::prefix('master')->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\UserController@view')->name('extraweb.master.users.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\UserController@view')->name('extraweb.master.users.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\UserController@get_list')->name('extraweb.master.users.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\UserController@create')->name('extraweb.master.users.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\UserController@edit')->name('extraweb.master.users.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\UserController@update')->name('extraweb.master.users.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\UserController@insert')->name('extraweb.master.users.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\UserController@remove')->name('extraweb.master.users.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\UserController@delete')->name('extraweb.master.users.delete');
                Route::post('/get_list_menu', 'App\Http\Controllers\Backend\Master\UserController@get_list_menu')->name('extraweb.master.users.get_list_menu');
                Route::post('/get_list_permission', 'App\Http\Controllers\Backend\Master\UserController@get_list_permission')->name('extraweb.master.users.get_list_permission');
            });
            Route::prefix('group')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\GroupController@view')->name('extraweb.master.group.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\GroupController@view')->name('extraweb.master.group.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\GroupController@get_list')->name('extraweb.master.group.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\GroupController@create')->name('extraweb.master.group.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\GroupController@edit')->name('extraweb.master.group.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\GroupController@update')->name('extraweb.master.group.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\GroupController@insert')->name('extraweb.master.group.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\GroupController@remove')->name('extraweb.master.group.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\GroupController@delete')->name('extraweb.master.group.delete');
            });
            Route::prefix('permission')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\PermissionController@view')->name('extraweb.master.permission.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\PermissionController@view')->name('extraweb.master.permission.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\PermissionController@get_list')->name('extraweb.master.permission.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\PermissionController@create')->name('extraweb.master.permission.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\PermissionController@edit')->name('extraweb.master.permission.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\PermissionController@update')->name('extraweb.master.permission.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\PermissionController@insert')->name('extraweb.master.permission.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\PermissionController@remove')->name('extraweb.master.permission.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\PermissionController@delete')->name('extraweb.master.permission.delete');
            });
            Route::prefix('module')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\ModuleController@view')->name('extraweb.master.module.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\ModuleController@view')->name('extraweb.master.module.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\ModuleController@get_list')->name('extraweb.master.module.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\ModuleController@create')->name('extraweb.master.module.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\ModuleController@edit')->name('extraweb.master.module.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\ModuleController@update')->name('extraweb.master.module.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\ModuleController@insert')->name('extraweb.master.module.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\ModuleController@remove')->name('extraweb.master.module.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\ModuleController@delete')->name('extraweb.master.module.delete');
            });
            Route::prefix('menu')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\MenuController@view')->name('extraweb.master.menu.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\MenuController@view')->name('extraweb.master.menu.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\MenuController@get_list')->name('extraweb.master.menu.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\MenuController@create')->name('extraweb.master.menu.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\MenuController@edit')->name('extraweb.master.menu.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\MenuController@update')->name('extraweb.master.menu.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\MenuController@insert')->name('extraweb.master.menu.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\MenuController@remove')->name('extraweb.master.menu.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\MenuController@delete')->name('extraweb.master.menu.delete');
            });
            Route::prefix('controller')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\ContrController@view')->name('extraweb.master.method.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\ContrController@view')->name('extraweb.master.method.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\ContrController@get_list')->name('extraweb.master.method.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\ContrController@create')->name('extraweb.master.method.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\ContrController@edit')->name('extraweb.master.method.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\ContrController@update')->name('extraweb.master.method.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\ContrController@insert')->name('extraweb.master.method.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\ContrController@remove')->name('extraweb.master.method.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\ContrController@delete')->name('extraweb.master.method.delete');
            });
            Route::prefix('method')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Master\MethodController@view')->name('extraweb.master.method.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Master\MethodController@view')->name('extraweb.master.method.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Master\MethodController@get_list')->name('extraweb.master.method.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Master\MethodController@create')->name('extraweb.master.method.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Master\MethodController@edit')->name('extraweb.master.method.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Master\MethodController@update')->name('extraweb.master.method.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Master\MethodController@insert')->name('extraweb.master.method.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Master\MethodController@remove')->name('extraweb.master.method.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Master\MethodController@delete')->name('extraweb.master.method.delete');
            });
        });
        Route::prefix('prefferences')->group(function () {
            Route::prefix('user')->group(function () {
                Route::prefix('groups')->group(function () {
                    Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@view')->name('extraweb.prefferences.UserGroup.view2');
                    Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@get_list')->name('extraweb.prefferences.UserGroup.view2');
                    Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@create')->name('extraweb.prefferences.UserGroup.create');
                    Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@edit')->name('extraweb.prefferences.UserGroup.edit');
                    Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@update')->name('extraweb.prefferences.UserGroup.update');
                    Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@insert')->name('extraweb.prefferences.UserGroup.insert');
                    Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@remove')->name('extraweb.prefferences.UserGroup.remove');
                    Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\UserGroupController@delete')->name('extraweb.prefferences.UserGroup.delete');
                });
            });
            Route::prefix('group')->group(function () {
                 Route::prefix('permissions')->group(function () {
                    Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@view')->name('extraweb.prefferences.GroupPermissions.view2');
                    Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@get_list')->name('extraweb.prefferences.GroupPermissions.view2');
                    Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@create')->name('extraweb.prefferences.GroupPermissions.create');
                    Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@edit')->name('extraweb.prefferences.GroupPermissions.edit');
                    Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@update')->name('extraweb.prefferences.GroupPermissions.update');
                    Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@insert')->name('extraweb.prefferences.GroupPermissions.insert');
                    Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@remove')->name('extraweb.prefferences.GroupPermissions.remove');
                    Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupPermissionController@delete')->name('extraweb.prefferences.GroupPermissions.delete');
                });
            });
        });
    });
    /*
     * 
     * extraweb routes end here
     * 
     */
});

Route::group(['prefix' => 'microsite'], function ($e) {
    Route::group(['prefix' => 'games'], function ($e) {
        Route::get('/', 'App\Http\Controllers\Backend\GamesController@index')->name('games.index');
        Route::get('/ordered-numbers', 'App\Http\Controllers\Backend\GamesController@orderd_numbered')->name('games.orderd_numbered');
        Route::get('/matching-photos', 'App\Http\Controllers\Backend\GamesController@matching_photos')->name('games.matching_photos');
        Route::get('/pingpong', 'App\Http\Controllers\Backend\GamesController@pingpong')->name('games.pingpong');
        Route::get('/snake', 'App\Http\Controllers\Backend\GamesController@snake')->name('games.snake');
        Route::get('/flapy-bird', 'App\Http\Controllers\Backend\GamesController@flapy_bird')->name('games.flapy_bird');
    });

    Route::group(['prefix' => 'feature'], function ($e) {
        Route::get('/', 'App\Http\Controllers\Backend\FeatureController@index')->name('feature.index');
        Route::get('/image-to-ascii', 'App\Http\Controllers\Backend\FeatureController@image_to_ascii')->name('feature.image-to-ascii');
    });
});
Route::get('/get-all-session', function (Request $request) {
    dd(session()->all());
});

Route::get('/flush-session', function (Request $request) {
    Authenticate::clear_session();
    dd(session()->all());
});

Route::post('/remove-session-flash', function (Request $request) {
    $type = $request->type;
    $close = ($request->close) ? true : false;
    $data = $request->session()->all();
    $arr_session_key = array_keys($data);
    if ($arr_session_key) {
        foreach ($arr_session_key AS $keywords => $values) {
            if ($values == 'alert-msg' && $close == true && $type == 'alert') {
                session()->forget($values);
            }
        }
    }
    session()->save();
});
