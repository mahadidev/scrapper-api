<?php

use App\Http\Controllers\API\V1\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware("cors")->group(function () {
    // register
    Route::post('/register', [UserController::class, 'register']);

    // login
    Route::post('/login', [UserController::class, 'login']);


    // update user
    Route::middleware('auth:sanctum')->prefix("user")->group(function () {
        Route::post("/reset-password", [UserController::class, 'resetPassword']);
        Route::post("/update", [UserController::class, 'update']);
        Route::post("/check", [UserController::class, 'check']);
    });
});