<?php

use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::namespace('\App\Http\Controllers\Admin')->group(function () {
        Route::get('/users/{editable}', 'UsersController@edit')
            ->name('admin.user.edit')
            ->middleware('can:edit user');
        Route::get('/users', 'UsersController@index')
            ->name('admin.users')
            ->middleware('can:general users');
        Route::post('/users', 'UsersController@store')
            ->name('admin.users.store')
            ->middleware('can:create user');
        Route::patch('/users/{user}/restore', 'UsersController@restore')
            ->name('admin.user.restore')
            ->middleware('can:edit status');
        Route::put('/users/{user}/update', 'UsersController@update')
            ->name('admin.user.update')
            ->middleware('can:edit user');
        Route::patch('/users/{user}/roles', 'UsersController@updateRoles')
            ->name('admin.user.roles')
            ->middleware('can:edit role');
        Route::delete('/users/{user}', 'UsersController@destroy')
            ->name('admin.user.delete')
            ->middleware('can:edit status');
        Route::delete('/users/{user}/force', 'UsersController@forceDestroy')
            ->name('admin.user.force')
            ->middleware('can:delete user');

        Route::get('/logs', 'LogsController@index')
            ->name('admin.logs')
            ->middleware('can:general logs'); // @todo

        Route::get('/employees', 'EmployeeController@index')
            ->name('admin.employee.index')
            ->middleware('can:general employees', 'remember'); //@todo
        Route::post('/employees', 'EmployeeController@store')
            ->name('admin.employee.store')
            ->middleware('can:create employee'); //@todo
        Route::patch('/employees/{employee}/reactivate', 'EmployeeController@reactivate')
            ->name('admin.employee.reactivate')
            ->middleware('can:update employee');
        Route::patch('/employees/{employee}/deactivate', 'EmployeeController@deactivate')
            ->name('admin.employee.deactivate')
            ->middleware('can:update employee');

        Route::get('/auto', 'AutoController@index')
            ->name('admin.auto.index')
            ->middleware('can:general auto');
        Route::post('/auto', 'AutoController@store')
            ->name('admin.auto.store')
            ->middleware('can:general auto');
        Route::delete('/auto/{auto}', 'AutoController@remove')
            ->name('admin.auto.remove')
            ->middleware('can:general auto');
        Route::get('/auto/{auto}', 'AutoController@edit')
            ->name('admin.auto.edit')
            ->middleware('can:general auto');
        Route::patch('/auto/itp/{auto}', 'AutoController@updateItp')
            ->name('admin.auto.update-itp')
            ->middleware('can:general auto');
        Route::patch('/auto/insurance/{auto}', 'AutoController@updateInsurance')
            ->name('admin.auto.update-insurance')
            ->middleware('can:general auto');
        Route::patch('/auto/upload/{auto}', 'AutoController@uploadDocuments')
            ->name('admin.auto.upload-documents')
            ->middleware('optimizeImages', 'can:general auto');
        Route::patch('/auto/remove/{auto}', 'AutoController@deleteDocuments')
            ->name('admin.auto.delete-documents', 'can:general auto');

        Route::get('/raports', 'RaportController@index')
            ->name('admin.raport.index');
        Route::get('/raports/automobiles', 'RaportController@autoReport')
            ->name('admin.raport.auto');

        Route::get('/locations', 'LocationController@index')
            ->name('admin.locations.index')
            ->middleware('remember', 'can:general locations');
        Route::post('/locations', 'LocationController@store')
            ->name('locations.store')
            ->middleware('can:create location');
        Route::delete('/locations/{location}', 'LocationController@delete')
            ->name('locations.delete')
            ->middleware('can:delete location');

        Route::get('/departures', 'DepartureController@index')
            ->name('admin.departure.index')
            ->middleware('can:general departures');
        Route::post('/departures', 'DepartureController@save')
            ->name('admin.departure.store')
            ->middleware('can:general departures');
        Route::delete('/departures/{ticket}', 'DepartureController@delete')
            ->name('admin.departure.delete')
            ->middleware('can:general departures');
        Route::get('/departures/{ticket}', 'DepartureController@download')
            ->name('admin.departure.download')
            ->middleware('can:general departures');
    });
});

Route::get('/', function () {
    return response()->redirectTo('/user/profile');
});
