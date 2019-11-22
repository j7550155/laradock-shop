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
Route::get('/shop', "ProductController@index");

Route::group(['prefix' => 'products'], function () {
    Route::get('/test', 'ProductController@test');
    Route::get('/', 'ProductController@index');
    Route::get('/{id}', 'ProductController@one');
    
});

// Route::get('/admin','AdminController@index');
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::post('/product', 'AdminController@addProduct');
    Route::get('/order', 'AdminController@orderSearch');
    Route::post('/editProduct', 'AdminController@editProduct');
    Route::post('/posts', 'AdminController@posts');
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/readNotify', 'HomeController@markRead');
Route::get('/cart', 'HomeController@cartList');
Route::post('/cart/add', 'HomeController@addCart');
Route::get('/cart/del/{cartId}', 'HomeController@delCart');
Route::get('/buy', 'HomeController@buy');
