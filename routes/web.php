<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CategorysController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\ServiceRequestsController;
use App\Http\Controllers\Admin\LineSettingsController;
use App\Http\Controllers\Admin\EdTechController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AssignTaskController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Auth\PSUAuthController;
Route::redirect('/', '/login');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('auth/psu', [PSUAuthController::class, 'redirectToPSU'])->name('auth.psu');
Route::get('auth/callback', [PSUAuthController::class, 'handlePSUCallback']);

Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    Route::resource('categorys', CategorysController::class);
    Route::resource('departments', DepartmentsController::class);
    Route::resource('service_requests',ServiceRequestsController::class);
    Route::resource('line_settings',LineSettingsController::class);
    Route::resource('edtech_connects',EdTechController::class);
    
    Route::get('callbacks', 'CallbacksController@callback')->name('callbacks.callback');

    Route::group(['prefix' => 'schedule', 'as' => 'schedule.'], function(){
        Route::controller(ScheduleController::class)->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('list', 'list')->name('list');
            Route::post('save/{id?}', 'save')->name('save');
            Route::get('find/{id?}', 'find')->name('find');
            Route::post('delete/{id?}', 'delete')->name('delete');
            Route::get('download/{id?}', 'download')->name('download');
            Route::post('job_status', 'job_status')->name('job_status');
            Route::get('selectdepartments/', 'selectdepartments')->name('selectdepartments');
        });
    });

    Route::group(['prefix' => 'assign_tasks', 'as' => 'assign_tasks.'], function(){
        Route::controller(AssignTaskController::class)->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('list', 'list')->name('list');
            Route::post('save/{id?}', 'save')->name('save');
            Route::get('find/{id?}', 'find')->name('find');
            Route::post('delete/{id?}', 'delete')->name('delete');
        });
    });

    Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
        Route::get('/', [SearchController::class, 'index'])->name('index');
        Route::get('/search', [SearchController::class, 'search'])->name('search');
    });
});
