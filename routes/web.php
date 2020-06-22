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

Route::get('/tool', 'ItemController@display')->middleware('admin')->name('tool');
Route::post('/tool/insert', 'ItemController@insert')->name('tool.insert');
Route::put('/tool/update/{item}', 'ItemController@update')->name('tool.update');
Route::put('/tool/switch/{item}', 'ItemController@switch')->name('tool.switch');
Route::delete('/tool/delete/{item}', 'ItemController@destroy')->name('tool.delete');

Route::get('/index', 'ItemController@show')->name('index');

Route::get('/cart', 'CartController@display')->name('cart');
Route::post('/cart/add/{item_id}', 'CartController@add')->name('cart.add');
Route::put('/cart/update/{item_id}', 'CartController@update')->name('cart.update');
Route::delete('/cart/delete/{item_id}', 'CartController@destroy')->name('cart.delete');

Route::post('/finish', 'CartController@purchase')->name('finish');

Route::get('/result', 'ResultController@display')->name('result');

Route::post('/detail/{result_id}', 'DetailController@display')->name('detail');