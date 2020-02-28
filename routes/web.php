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

Route::post('/task/create', 'TaskController@create');
Route::get('/task/read', 'TaskController@read');
Route::post('/task/update', 'TaskController@update');
Route::post('/task/delete', 'TaskController@delete');

Route::fallback(function () {
    return view('welcome');
});
