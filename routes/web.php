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

Route::get('/', 'ThreadController@index');

Auth::routes();

// Thread
Route::resource('thread', 'ThreadController');

// User
Route::get('/user/{id}', 'UserController@show');

Route::get('/user/{id}/thread', 'UserController@showThread');

Route::get('/user/{id}/comment', 'UserController@showComment');

Route::get('/user/{id}/edit', 'UserController@edit');

Route::put('/user/{id}', 'UserController@update');

// Comment
Route::post('/comment/create/{id}', 'CommentController@create')->name('comment.form');

Route::post('/comment/store', 'CommentController@store')->name('comment.create');

Route::post('/comment/update', 'CommentController@update')->name('comment.update');

Route::delete('/comment/{id}', 'CommentController@destroy')->name('comment.delete');

// Reply
Route::post('reply/store', 'ReplyController@store')->name('reply.create');

Route::post('/reply/update', 'ReplyController@update')->name('reply.update');

Route::delete('/reply/{id}', 'ReplyController@destroy')->name('reply.delete');