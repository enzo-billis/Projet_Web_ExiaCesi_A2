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
Route::get('manif/{id}','ManifestationsController@APIManifFiltered');
Route::get('manif','ManifestationsController@APIManifs')->name('APIManifs');
Route::get('shop/catalog','catalogController@APICatalog')->name('APICatalog');
Route::get('manif','ManifestationsController@APIIndex');
Route::get('manif/{id}','ManifestationsController@APIShow');
Route::get('shop/category/{category}','catalogController@APIByName')->name('APIcategory');

Route::get('shop','catalogController@APIIndex');
Route::get('shop/{id}','catalogController@APIShow');

Route::get('user','userController@APIIndex');
Route::get('user/{id}','userController@APIShow');