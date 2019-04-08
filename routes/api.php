<?php


Route::as('api.')->group(function () {
    Route::post('login', 'Api\LoginController')->name('login');

    Route::resource('posts', 'Api\PostsController');
});
