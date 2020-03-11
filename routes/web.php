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

Auth::routes();

Route::post('/task/create', 'TaskController@create');
Route::get('/task/read', 'TaskController@read');
Route::post('/task/complete', 'TaskController@complete');
Route::post('/task/delete', 'TaskController@delete');

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::fallback(function () {
    return redirect('/');
});
