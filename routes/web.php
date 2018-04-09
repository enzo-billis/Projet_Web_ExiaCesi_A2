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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile/{id}','ProfileController@index');
Route::post('/manif/{id}/register','ManifestationsController@registration')->name('register');
Route::get('/profile','ProfileController@UserConnected');
Route::get('/manif/{id}','ManifestationsController@index')->name('manif');
Route::get('/manif','ManifestationsController@allManif')->name('manifs');
