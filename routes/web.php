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

Route::get('/', 'RoomController@index')->name('home');

Route::get('messages/{room}', 'ChatController@messages');
Route::post('messages/{room}', 'ChatController@store');

Route::get('rooms/all', 'RoomController@all');
Route::post('rooms', 'RoomController@store');
route::get('rooms/{room}', 'RoomController@show');
Route::delete('rooms/{room}', 'RoomController@destroy');
