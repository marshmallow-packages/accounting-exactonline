<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/authenticate', 'Marshmallow\ExactOnline\Http\Controllers\AuthenticationController@authenticate');
Route::get('/disconnect', 'Marshmallow\ExactOnline\Http\Controllers\AuthenticationController@disconnect');
Route::get('/validate', 'Marshmallow\ExactOnline\Http\Controllers\AuthenticationController@validateConnection');
Route::get('/me', 'Marshmallow\ExactOnline\Http\Controllers\AuthenticationController@me');
Route::get('/connected', 'Marshmallow\ExactOnline\Http\Controllers\AuthenticationController@connected');
Route::post('/show', 'Marshmallow\ExactOnline\Http\Controllers\ExactOnlineController@show');