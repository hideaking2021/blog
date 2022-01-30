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

//ブログ一覧表示
Route::get('/', 'BlogController@showList')->name
('blogs');

//ブログ登録画面表示
Route::get('/blog/create', 'BlogController@showCreate')->name
('create');

//ブログ登録
Route::post('/blog/store', 'BlogController@exeStore')->name
('store');

//ブログ詳細画面表示
Route::get('/blog/{id}', 'BlogController@showDetail')->name
('show');
