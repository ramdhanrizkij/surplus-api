<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('auth')->group(function(){
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categories')->group(function(){
    Route::get('/',[CategoryController::class,'index']);
    Route::post('/',[CategoryController::class,'store']);
    Route::put('/{id}',[CategoryController::class,'save']);
    Route::get('/{id}',[CategoryController::class,'getById']);
    Route::delete('/{id}',[CategoryController::class,'delete']);
});

Route::prefix('product')->group(function(){
    Route::get('/',[ProductController::class,'index']);
    Route::post('/',[ProductController::class,'store']);
    Route::put('/{id}',[ProductController::class,'save']);
    Route::get('/{id}',[ProductController::class,'getById']);
    Route::delete('/{id}',[ProductController::class,'delete']);
});

Route::prefix('images')->group(function(){
    Route::get('/',[ImageController::class,'index']);
    Route::post('/',[ImageController::class,'store']);
    Route::post('update/{id}',[ImageController::class,'save']);
    Route::get('/{id}',[ImageController::class,'getById']);
    Route::delete('/{id}',[ImageController::class,'delete']);
});
