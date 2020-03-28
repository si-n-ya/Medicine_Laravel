<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ItemsController@index');

Route::get('/add', 'ItemsController@add');
Route::post('add', 'ItemsController@create');

Route::get('/check', 'ItemsController@check');
Route::post('/check', 'StatesController@ajax');

Route::get('/list', 'ItemsController@list');
Route::get('/list/edit/{id?}', 'ItemsController@edit');

Route::post('/list/edit/{id}', 'ItemsController@update');

Route::post('/list/{id?}', 'ItemsController@delete');

Route::get('/history', 'ItemsController@history');
Route::post('/history', 'ItemsController@search');
Route::post('/history/delete', 'StatesController@delete');
// Route::post('/history', 'StatesController@search');