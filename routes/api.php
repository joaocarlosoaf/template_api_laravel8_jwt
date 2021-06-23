<?php

use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::get('me', 'App\Http\Controllers\AuthController@me');
});

Route::group([
    'prefix' => 'v1',
    'middleware' => 'auth:api',//'jwt.auth',
], function ($router) {
    Route::get('categories/{id}/products', 'App\Http\Controllers\API\v1\CategoryController@products');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});