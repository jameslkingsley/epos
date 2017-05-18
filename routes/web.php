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
    return view('dashboard');
});

Route::get('/session', function() {
    return session()->all();
});

Route::resource('/api/categories', 'CategoryController');
Route::resource('/api/basket', 'BasketController');
Route::resource('/api/basket-items', 'BasketItemController');

Auth::routes();
