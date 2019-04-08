<?php

Route::get('/', '\Acme\Http\Controllers\PostsController@index')->name('posts.index');
Route::get('posts/create', '\Acme\Http\Controllers\PostsController@create')->name('posts.create');
Route::get('posts/{post}', '\Acme\Http\Controllers\PostsController@show')->name('posts.show');
Route::post('posts', '\Acme\Http\Controllers\PostsController@store')->name('posts.store');
Route::get('posts/{post}/edit', '\Acme\Http\Controllers\PostsController@edit')->name('posts.edit');
Route::patch('posts/{post}', '\Acme\Http\Controllers\PostsController@update')->name('posts.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
