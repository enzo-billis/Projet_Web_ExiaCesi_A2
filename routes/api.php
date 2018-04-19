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
Route::get('/api/manif/{id}','ManifestationsController@APIManifFiltered');
Route::get('/api/manif','ManifestationsController@APIManifs')->name('APIManifs');
Route::get('/api/index/manif','ManifestationsController@APIIndex');
Route::get('/api/shop', 'catalogController@APICatalog')->name('APICatalog');
Route::get('/api/shop/{name}', 'catalogController@APISelect')->name('APISelect');
Route::get('/api/shop/{category}','catalogController@APIShowByName')->name('APIcategory');
Route::get('/api/carts','buyController@APIshowCart')->name('APIBuy');
Route::get('/api/ideas','IdeaController@APIAllIdeas')->name('APIIdeas');
Route::get('/api/ideas/{id}','ideaController@APIIdea')->name('APIIdea');
Route::get('/api/pictures','PictureController@APIPictures')->name('APIPictures');
Route::get('/api/pictures/{id}','PictureController@APIPicture')->name('APIPicture');
Route::get('/api/users','UserController@APIAllController')->name('APIUsers');
Route::get('/api/users/{id}','UserController@APIController')->name('APIUser');
Route::get('/api/Inscription','InscriptionController@APIAllInscriptions')->name('APIInscriptions');
Route::get('/api/Inscription/{id}','InscriptionController@APIInscription')->name('APIInscription');