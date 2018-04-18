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

Route::get('/', function () {return view('welcome');});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@index')->name('home');

//Route for profile
Route::get('/profile/{id}','ProfileController@index');
Route::get('/profile','ProfileController@UserConnected');

//Route for manifestations
Route::get('/manif/{id}','ManifestationsController@index')->name('manif');
Route::get('/manif','ManifestationsController@allManif')->name('manifs');
Route::post('/manif/{id}/register','InscriptionController@registration')->name('registerManif')->middleware('auth');
Route::post("/manif/{id}/upload",'PictureController@savePic')->name('savePic')->middleware('auth');
Route::post("/manif/new",'ManifestationsController@newManif')->name('newManif')->middleware('bde');
Route::post("/manif/download",'PictureController@downloadZip')->name('downloadPack')->middleware('employee');

//Route for ideas
Route::get('/ideas/{id}','IdeaController@index')->name('idea');
Route::get('/ideas','IdeaController@allIdeas')->name('ideas');
Route::post('/ideas/{id}/moins','VoteController@changeVoteDown')->name('VoteDown')->middleware('auth');
Route::post('/ideas/{id}/plus','VoteController@changeVoteUp')->name('VoteUp')->middleware('auth');
Route::post('/ideas/{id}/moins','VoteController@changeVoteDown')->name('VoteDown')->middleware('auth');
Route::post('/ideas/new','IdeaController@newIdea')->name('newIdea')->middleware('auth');

//Route for pictures
Route::get("/picture/{id}",'PictureController@index')->name('picture');
Route::post("/picture/{id}/like",'PictureController@like')->name('likePic')->middleware('auth');
Route::post("/picture/{id}/comment",'PictureController@comment')->name('commentPic')->middleware('auth');
Route::post("/deletePic",'PictureController@delete')->name('deletePic')->middleware('auth');
Route::post("/deleteCom",'CommentController@delete')->name('deleteCom')->middleware('auth');

//Route for notif
Route::post('/notification/get','NotificationsController@get');
Route::post('/notification/read','NotificationsController@read')->middleware('auth');

//Route for produits
Route::get('/shop','catalogController@showCatalog')->name('shopList');
Route::get('/shop/add','catalogController@addProduct')->name('newProduct');
Route::get("/shop/modify/{id}",'catalogController@EditProduct');
Route::get("/shop/rem/{id}","catalogController@removeProduct");
Route::post('/shop/post','catalogController@PostAddProduct')->name('PostNewProduct');
Route::post("/shop/modify/post/",'catalogController@postEditProduct')->name('PostAltProduct');

//Route for buy/cart
Route::get('/cart','buyController@showCart')->name('cart');
