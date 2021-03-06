<?php

use App\User;

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
    return view('till');
});

Route::get('/test-login/{user}', function(Request $request, User $user) {
    auth()->login($user, true);

    return auth()->user();
});

Route::get('/session', function() {
    return session()->all();
});

Route::resource('/admin', 'AdminController');

Route::resource('/api/categories', 'CategoryController');

Route::delete('/api/basket', 'BasketController@empty');
Route::put('/api/basket/mode/{mode}', 'BasketController@mode');
Route::resource('/api/basket', 'BasketController', [
    'except' => 'destroy'
]);

Route::delete('/api/items/{item}/{qty}', 'ItemController@destroy');
Route::post('/api/items/add-many/{count}', 'ItemController@addMany');
Route::post('/api/items/via-barcode', 'ItemController@addViaBarcode');
Route::resource('/api/items', 'ItemController');

Route::post('/api/payments/service', 'PaymentController@service');
Route::delete('/api/payments/service/{payment}', 'PaymentController@cancelService');
Route::resource('/api/payments', 'PaymentController');

Route::resource('/api/receipt', 'ReceiptController');

Route::resource('/api/transactions', 'TransactionController');

Auth::routes();
