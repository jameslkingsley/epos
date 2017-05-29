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
    return view('layouts.app');
});

Route::get('/session', function() {
    return session()->all();
});

Route::resource('/api/categories', 'CategoryController');

Route::delete('/api/basket', 'BasketController@empty');
Route::resource('/api/basket', 'BasketController', [
    'except' => 'destroy'
]);

Route::delete('/api/items/{item}/{qty}', 'ItemController@destroy');
Route::post('/api/items/add-many/{count}', 'ItemController@addMany');
Route::resource('/api/items', 'ItemController');

Route::resource('/api/payments', 'PaymentController');

Auth::routes();
