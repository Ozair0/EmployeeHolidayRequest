<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\LeavesController;

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

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);
    Route::post('/profile_by_id', [JWTController::class, 'profile_by_id']);

    /*
    * Leave APIs
    */

    Route::post('/leave/store', [LeavesController::class, 'store']);
    Route::get('/leave/get_all', [LeavesController::class, 'get_all']);
    Route::get('/leave/get', [LeavesController::class, 'get_self']);
    Route::put('/leave/update', [LeavesController::class, 'update_leave']);
});
