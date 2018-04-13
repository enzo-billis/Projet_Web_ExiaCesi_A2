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

use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route for profile
Route::get('/profile/{id}','ProfileController@index');
Route::get('/profile','ProfileController@UserConnected');

//Route for manifestations
Route::get('/manif/{id}','ManifestationsController@index')->name('manif');
Route::get('/manif','ManifestationsController@allManif')->name('manifs');
Route::post('/manif/{id}/register','InscriptionController@registration')->name('registerManif');

//Route for ideas
Route::get('/ideas/{id}','IdeaController@index')->name('idea');
Route::post('/ideas/{id}/plus','VoteController@changeVoteUp')->name('VoteUp');
Route::post('/ideas/{id}/moins','VoteController@changeVoteDown')->name('VoteDown');

//Route for produits
Route::get('/shop','catalogController@showCatalog')->name('shopList');
Route::get("/shop/add",'catalogController@addProduct')->name('newProduct');
Route::post('/shop/add/{name,description,image,price','catalogController@PostAddProduct')->name('PostNewProduct');
Route::post("/shop/modify/{id}",'catalogController@editProduct')->name('AltProduct');
Route::post("/shop/rem/{id}","catalogController@removeProduct")->name("delProduct");