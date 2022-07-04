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
            return Authenticate::validate_user($request->all());
        })->name('extraweb.validate');
        Route::post('/save-token', function (Request $request) {
            return Authenticate::save_token($request->all());
        })->name('extraweb.save_token');
        Route::get('/dashboard', 'App\Http\Controllers\Backend\DashboardController@index')->name('extraweb.dashboard');

        Route::prefix('ajax')->group(function () {
            Route::get('/get/{method}', 'App\Http\Controllers\Globals\AjaxController@fn_ajax_get')->name('global.ajax_get');
            Route::post('/post/{method}', 'App\Http\Controllers\Globals\AjaxController@fn_ajax_post')->name('global.ajax_post');
        });

        Route::prefix('profile')->group(function () {
            Route::get('/view', 'App\Http\Controllers\Backend\ProfileController@view')->name('extraweb.profile');
            Route::get('/update', 'App\Http\Controllers\Backend\ProfileController@update')->name('extraweb.profile_update');
            Route::post('/upload_photo', 'App\Http\Controllers\Backend\ProfileController@fnUploadPhoto')->name('extraweb.fnUploadPhoto');
        });

        Route::prefix('classes')->group(function () {
            Route::get('/view', 'App\Http\Controllers\Backend\ClassesController@view')->name('extraweb.classes.view');
            Route::get('/create', 'App\Http\Controllers\Backend\ClassesController@create')->name('extraweb.classes.create');
            Route::post('/get_list', 'App\Http\Controllers\Backend\ClassesController@get_list')->name('extraweb.classes.get_list');
            Route::get('/edit/{id}', 'App\Http\Controllers\Backend\ClassesController@edit')->name('extraweb.classes.edit');
            Route::post('/update/{id}', 'App\Http\Controllers\Backend\ClassesController@update')->name('extraweb.classes.update');
            Route::post('/insert', 'App\Http\Controllers\Backend\ClassesController@insert')->name('extraweb.classes.insert');
        });

        Route::prefix('prefferences')->group(function () {
            Route::prefix('menu')->group(function () {
                Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\MenuController@view')->name('extraweb.menu.view');
                Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\MenuController@create')->name('extraweb.menu.create');
                Route::get('/tree_view', 'App\Http\Controllers\Backend\Prefferences\MenuController@tree_view')->name('extraweb.menu.tree_view');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\MenuController@get_list')->name('extraweb.menu.get_list');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\MenuController@edit')->name('extraweb.menu.edit');
                Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\MenuController@insert')->name('extraweb.menu.insert');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\MenuController@update')->name('extraweb.menu.update');
                Route::get('/re_index_menu/{module}/{level}', 'App\Http\Controllers\Backend\Prefferences\MenuController@re_index_menu')->name('extraweb.menu.re_index_menu');
            });
            Route::prefix('user')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Prefferences\UsersController@view')->name('extraweb.prefferences.users.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\UsersController@view')->name('extraweb.prefferences.users.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\UsersController@get_list')->name('extraweb.prefferences.users.get_list');
                Route::get('/archive', 'App\Http\Controllers\Backend\Prefferences\UsersController@archive')->name('extraweb.prefferences.users.archive');
                Route::post('/get_list_archive', 'App\Http\Controllers\Backend\Prefferences\UsersController@get_list_archive')->name('extraweb.prefferences.users.get_list_archive');
                Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\UsersController@create')->name('extraweb.prefferences.users.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@edit')->name('extraweb.prefferences.users.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@update')->name('extraweb.prefferences.users.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\UsersController@insert')->name('extraweb.prefferences.users.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@remove')->name('extraweb.prefferences.users.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@delete')->name('extraweb.prefferences.users.delete');

                Route::prefix('auth')->group(function () {
                    Route::get('/', 'App\Http\Controllers\Backend\Prefferences\UsersController@view_auth')->name('extraweb.prefferences.users.view_auth');
                    Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\UsersController@create')->name('extraweb.prefferences.users.create_auth');
                    Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\UsersController@get_list_auth')->name('extraweb.prefferences.users.get_list_auth');
                    Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@update_auth')->name('extraweb.prefferences.users.update_auth');
                    Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\UsersController@insert_auth')->name('extraweb.prefferences.users.insert_auth');
                    Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@remove_auth')->name('extraweb.prefferences.users.remove_auth');
                    Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\UsersController@delete_auth')->name('extraweb.prefferences.users.delete_auth');
                });
            });
            Route::prefix('group')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Prefferences\GroupsController@view')->name('extraweb.prefferences.group.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\GroupsController@view')->name('extraweb.prefferences.group.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\GroupsController@get_list')->name('extraweb.prefferences.group.get_list');
                Route::get('/archive', 'App\Http\Controllers\Backend\Prefferences\GroupsController@archive')->name('extraweb.prefferences.group.archive');
                Route::post('/get_list_archive', 'App\Http\Controllers\Backend\Prefferences\GroupsController@get_list_archive')->name('extraweb.prefferences.group.get_list_archive');
                Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\GroupsController@create')->name('extraweb.prefferences.group.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsController@edit')->name('extraweb.prefferences.group.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsController@update')->name('extraweb.prefferences.group.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\GroupsController@insert')->name('extraweb.prefferences.group.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsController@remove')->name('extraweb.prefferences.group.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsController@delete')->name('extraweb.prefferences.group.delete');
            });
            Route::prefix('permission')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Prefferences\PermissionController@view')->name('extraweb.prefferences.permission.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\PermissionController@view')->name('extraweb.prefferences.permission.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\PermissionController@get_list')->name('extraweb.prefferences.permission.get_list');
                Route::get('/archive', 'App\Http\Controllers\Backend\Prefferences\PermissionController@archive')->name('extraweb.prefferences.permission.archive');
                Route::post('/get_list_archive', 'App\Http\Controllers\Backend\Prefferences\PermissionController@get_list_archive')->name('extraweb.prefferences.permission.get_list_archive');
                Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\PermissionController@create')->name('extraweb.prefferences.permission.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\PermissionController@edit')->name('extraweb.prefferences.permission.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\PermissionController@update')->name('extraweb.prefferences.permission.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\PermissionController@insert')->name('extraweb.prefferences.permission.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\PermissionController@remove')->name('extraweb.prefferences.permission.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\PermissionController@delete')->name('extraweb.prefferences.permission.delete');
            });
            Route::prefix('group_permission')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@view')->name('extraweb.prefferences.group_permission.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@view')->name('extraweb.prefferences.group_permission.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@get_list')->name('extraweb.prefferences.group_permission.get_list');
                Route::get('/archive', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@archive')->name('extraweb.prefferences.group_permission.archive');
                Route::post('/get_list_archive', 'App\Http\Controllers\Backend\GroupsPrefferences\PermissionController@get_list_archive')->name('extraweb.prefferences.group_permission.get_list_archive');
                Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@create')->name('extraweb.prefferences.group_permission.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@edit')->name('extraweb.prefferences.group_permission.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@update')->name('extraweb.prefferences.group_permission.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@insert')->name('extraweb.prefferences.permission.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@remove')->name('extraweb.prefferences.group_permission.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\GroupsPermissionsController@delete')->name('extraweb.prefferences.group_permission.delete');
            });
             Route::prefix('module')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Prefferences\ModulesController@view')->name('extraweb.prefferences.module.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Prefferences\ModulesController@view')->name('extraweb.prefferences.module.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Prefferences\ModulesController@get_list')->name('extraweb.prefferences.module.get_list');
                Route::get('/archive', 'App\Http\Controllers\Backend\Prefferences\ModulesController@archive')->name('extraweb.prefferences.module.archive');
                Route::post('/get_list_archive', 'App\Http\Controllers\Backend\Prefferences\ModulesController@get_list_archive')->name('extraweb.prefferences.module.get_list_archive');
                Route::get('/create', 'App\Http\Controllers\Backend\Prefferences\ModulesController@create')->name('extraweb.prefferences.module.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Prefferences\ModulesController@edit')->name('extraweb.prefferences.module.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Prefferences\ModulesController@update')->name('extraweb.prefferences.module.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Prefferences\ModulesController@insert')->name('extraweb.prefferences.module.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Prefferences\ModulesController@remove')->name('extraweb.prefferences.module.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Prefferences\ModulesController@delete')->name('extraweb.prefferences.module.delete');
            });
        });
        Route::prefix('project')->group(function () {
            Route::get('/', 'App\Http\Controllers\Backend\Project\MainController@view')->name('extraweb.project.main.view1');
            Route::get('/view', 'App\Http\Controllers\Backend\Project\MainController@view')->name('extraweb.project.main.view2');
            Route::post('/get_list', 'App\Http\Controllers\Backend\Project\MainController@get_list')->name('extraweb.project.main.get_list');
            Route::get('/archive', 'App\Http\Controllers\Backend\Project\MainController@archive')->name('extraweb.project.main.archive');
            Route::post('/get_list_archive', 'App\Http\Controllers\Backend\Project\MainController@get_list_archive')->name('extraweb.project.main.get_list_archive');
            Route::get('/create', 'App\Http\Controllers\Backend\Project\MainController@create')->name('extraweb.project.main.create');
            Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\MainController@edit')->name('extraweb.project.main.edit');
            Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\MainController@update')->name('extraweb.project.main.update');
            Route::post('/insert', 'App\Http\Controllers\Backend\Project\MainController@insert')->name('extraweb.project.main.insert');
            Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\MainController@remove')->name('extraweb.project.main.remove');
            Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\MainController@delete')->name('extraweb.project.main.delete');

            Route::prefix('type')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Project\TypeController@view')->name('extraweb.project.type.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Project\TypeController@view')->name('extraweb.project.type.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Project\TypeController@get_list')->name('extraweb.project.type.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Project\TypeController@create')->name('extraweb.project.type.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\TypeController@edit')->name('extraweb.project.type.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\TypeController@update')->name('extraweb.project.type.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Project\TypeController@insert')->name('extraweb.project.type.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\TypeController@remove')->name('extraweb.project.type.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\TypeController@delete')->name('extraweb.project.type.delete');
            });
            Route::prefix('developer-teams')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Project\DeveloperController@view')->name('extraweb.project.developer.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Project\DeveloperController@view')->name('extraweb.project.developer.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Project\DeveloperController@get_list')->name('extraweb.project.developer.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Project\DeveloperController@create')->name('extraweb.project.developer.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\DeveloperController@edit')->name('extraweb.project.developer.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\DeveloperController@update')->name('extraweb.project.developer.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Project\DeveloperController@insert')->name('extraweb.project.developer.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\DeveloperController@remove')->name('extraweb.project.developer.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\DeveloperController@delete')->name('extraweb.project.developer.delete');
            });
            Route::prefix('isu-teams')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Project\IsuController@view')->name('extraweb.project.isu.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Project\IsuController@view')->name('extraweb.project.isu.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Project\IsuController@get_list')->name('extraweb.project.isu.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Project\IsuController@create')->name('extraweb.project.isu.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\IsuController@edit')->name('extraweb.project.isu.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\IsuController@update')->name('extraweb.project.isu.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Project\IsuController@insert')->name('extraweb.project.isu.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\IsuController@remove')->name('extraweb.project.isu.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\IsuController@delete')->name('extraweb.project.isu.delete');
            });
            Route::prefix('teams')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Project\TeamController@view')->name('extraweb.project.team.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Project\TeamController@view')->name('extraweb.project.team.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Project\TeamController@get_list')->name('extraweb.project.team.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Project\TeamController@create')->name('extraweb.project.team.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\TeamController@edit')->name('extraweb.project.team.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\TeamController@update')->name('extraweb.project.team.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Project\TeamController@insert')->name('extraweb.project.team.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\TeamController@remove')->name('extraweb.project.team.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\TeamController@delete')->name('extraweb.project.team.delete');
            });
            Route::prefix('requirements')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Project\RequirementController@view')->name('extraweb.project.requirement.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Project\Requirementontroller@view')->name('extraweb.project.requirement.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Project\RequirementController@get_list')->name('extraweb.project.requirement.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Project\RequirementController@create')->name('extraweb.project.requirement.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\RequirementController@edit')->name('extraweb.project.requirement.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\RequirementController@update')->name('extraweb.project.requirement.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Project\RequirementController@insert')->name('extraweb.project.requirement.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\RequirementController@remove')->name('extraweb.project.requirement.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\RequirementController@delete')->name('extraweb.project.requirement.delete');
            });
            Route::prefix('photo')->group(function () {
                Route::get('/', 'App\Http\Controllers\Backend\Project\PhotoController@view')->name('extraweb.project.photo.view1');
                Route::get('/view', 'App\Http\Controllers\Backend\Project\PhotoController@view')->name('extraweb.project.photo.view2');
                Route::post('/get_list', 'App\Http\Controllers\Backend\Project\PhotoController@get_list')->name('extraweb.project.photo.get_list');
                Route::get('/create', 'App\Http\Controllers\Backend\Project\PhotoController@create')->name('extraweb.project.photo.create');
                Route::get('/edit/{id}', 'App\Http\Controllers\Backend\Project\PhotoController@edit')->name('extraweb.project.photo.edit');
                Route::post('/update/{id}', 'App\Http\Controllers\Backend\Project\PhotoController@update')->name('extraweb.project.photo.update');
                Route::post('/insert', 'App\Http\Controllers\Backend\Project\PhotoController@insert')->name('extraweb.project.photo.insert');
                Route::get('/remove/{id}', 'App\Http\Controllers\Backend\Project\PhotoController@remove')->name('extraweb.project.photo.remove');
                Route::get('/delete/{id}', 'App\Http\Controllers\Backend\Project\PhotoController@delete')->name('extraweb.project.photo.delete');
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
