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

use Illuminate\Support\Facades\Route;

Route::post('login', 'DevicesAuthController@login');
Route::post('register', 'DevicesAuthController@register');

Route::middleware('auth:api')->group(function () {
    Route::prefix('advertisements')->group(function () {
        Route::post('/request', 'AdvertisementsController@getDeviceAdvertisements')
            ->name('advertisements.getDeviceAdvertisements');
    });
});
