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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/manif/{id}','ManifestationsController@APIManifFiltered');
Route::get('/manif','ManifestationsController@APIManifs')->name('APIManifs');
Route::get('/shop/', 'catalogController@APICatalog')->name('APICatalog');
Route::get('/shop/{name}', 'catalogController@APISelect')->name('APISelect');