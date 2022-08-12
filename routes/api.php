<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ---------------------- Login Routes ----------------------
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// ---------------------- Other Routes ----------------------
Route::resource('/user', 'UserAccountController')->only(['index', 'show', 'update', 'destroy'])->middleware('auth:api');
Route::resource('/room', 'RoomTemplateController')->middleware('auth:api');