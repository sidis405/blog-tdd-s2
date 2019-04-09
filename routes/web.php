<?php

use Acme\Events\NewChatMessage;

Route::get('test', function () {
    \Auth::loginUsingId(1);

    $message = auth()->user()->messages()->create([
        'body' => 'Eureka'
    ]);

    event(new NewChatMessage($message));
});


Route::get('/', 'PostsController@index')->name('posts.index');
Route::resource('posts', 'PostsController')->except('index');

Route::get('messages', 'MessagesController@index')->name('messages.index');
Route::post('messages', 'MessagesController@store')->name('messages.store');
