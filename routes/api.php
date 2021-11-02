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
Route::post('/sign-up', [\App\Http\Controllers\Auth\AuthController::class,'store'])->name('users.store');
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [\App\Http\Controllers\Auth\AuthController::class,'login']);
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class,'logout']);
});
Route::middleware(['auth:api','admin'])->group(function(){
    Route::apiResource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class,'index']);
    Route::put('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class,'updateStatus']);
});
//Route::get('users', [\App\Http\Controllers\Admin\UserController::class,'index'])->name('users.index')->middleware('auth:api');

Route::group(['prefix' => 'website'], function(){
    Route::get('products', [\App\Http\Controllers\Website\ProductController::class,'index']);
    Route::get('products/{product:name}', [\App\Http\Controllers\Website\ProductController::class,'show']);
    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('orders', [\App\Http\Controllers\Website\OrderController::class, 'store']);
        Route::get('orders',[\App\Http\Controllers\Website\OrderController::class,'index']);
    });
});
