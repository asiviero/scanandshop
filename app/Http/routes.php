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

Route::get('/', 'Controller@show')->middleware('auth');;
Route::post('/list/add', 'Controller@add')->middleware('auth');;
Route::post('/list/send', 'Controller@send')->middleware('auth');;
Route::post('/list/', 'Controller@newList')->middleware('auth');;
Route::post('/product/', 'ProductController@create')->middleware('auth');;

Route::auth();

Route::get('/home', 'HomeController@index');
