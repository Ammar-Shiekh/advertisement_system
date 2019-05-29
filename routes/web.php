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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', function() {
    event(new \App\Events\AdvertisementRemoved(7, ['id' => 1]));
});

Route::middleware('auth')->group(function () {

    Route::middleware('publisher')->group(function () {
        Route::resource('/advertisements', 'AdvertisementsController');
    });

    Route::middleware('admin')->group(function () {
        Route::prefix('dashboard')->group(function() {
            Route::prefix('publishers')->group(function() {
                Route::get('', 'PublishersManagementController@index')
                    ->name('dashboard.publishers.index');
                Route::get('/edit-permissions/{id}', 'PublishersManagementController@editPermissions')
                    ->name('dashboard.publishers.editPermissions');
                Route::post('/update-permissions/{id}', 'PublishersManagementController@updatePermissions')
                    ->name('dashboard.publishers.updatePermissions');
            });
            Route::prefix('advertisements')->group(function() {
                Route::get('', 'AdvertisementsController@adminIndex')
                    ->name('dashboard.advertisements.index');
                Route::delete('/{id}', 'AdvertisementsController@adminDestroy')
                    ->name('dashboard.advertisements.destroy');
            });
        });
    });
});
