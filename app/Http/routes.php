<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Controller@show');
Route::post('/list/add', 'Controller@add');
Route::post('/list/send', 'Controller@send');
Route::post('/list/', 'Controller@newList');
Route::post('/product/', 'ProductController@create');
