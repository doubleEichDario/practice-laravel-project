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

// GENERAL PURPOSE
Route::get('/', 'HomeController@index')->name('home');
Route::get('/cuenta', 'UserController@config') -> name('config');

// USER
Route::post('/user/update', 'UserController@update') -> name('user-update');
Route::get('/user/avatar/{filename}', 'UserController@getImage') -> name('user-avatar');
Route::get('/user/profile/{id}', 'UserController@profile') -> name('user-profile');
Route::get('/people/{search?}', 'UserController@index') -> name('user-index');

// IMAGE
Route::get('/image/upload', 'ImageController@create') -> name('create-image');
Route::post('/image/save', 'ImageController@save') -> name('save-image');
Route::get('/image/file/{filename}', 'ImageController@getImage') -> name('post-image');
Route::get('/image/detail/{id}', 'ImageController@detail') -> name('image-detail');
Route::get('/image/delete/{id}', 'ImageController@delete') -> name('delete-image');
Route::get('/image/edit/{id}', 'ImageController@edit') -> name('edit-image');
Route::post('image/update', 'ImageController@update') -> name('update-image');

// COMMENT
Route::post('/comment/save', 'CommentController@save') -> name('save-comment');
Route::get('/comment/delete/{id}', 'CommentController@delete') -> name('delete-comment');

// LIKE
Route::get('/like/{image_id}', 'LikeController@like') -> name('save-like');
Route::get('/dislike/{image_id}', 'LikeController@dislike') -> name('delete-like');
