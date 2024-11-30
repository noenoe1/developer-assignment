<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ItemController;

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
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::group(['prefix' => 'items','middleware' => 'api'], function() {
    Route::get('/', [ItemController::class,'index']);
    Route::post('add', [ItemController::class,'store']);
    Route::post('update/{id}', [ItemController::class,'update']);
    Route::get('edit/{id}', [ItemController::class,'edit']);
    Route::delete('delete/{id}', [ItemController::class,'destroy']);
});
