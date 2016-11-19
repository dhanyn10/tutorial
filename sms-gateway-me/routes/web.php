<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('message', 'MessageController@index')->name('message.index');
Route::get('message/send', 'MessageController@form')->name('message.form');
Route::post('message/send', 'MessageController@send')->name('message.send');
Route::delete('message/{message}', 'MessageController@destroy')->name('message.delete');
