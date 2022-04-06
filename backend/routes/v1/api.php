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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Auth

Route::prefix('/auth')->group(function(){
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
});