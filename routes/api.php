<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'registerUser']);
Route::post('/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logoutUser']);

    Route::get('/user', [UserController::class, 'getUserDetail']);

    Route::prefix('urls')->group(function () {
        Route::get('/', [UrlController::class, 'getUserUrls']);
        Route::post('/shorten', [UrlController::class, 'shortenUrl']);
        Route::put('/shorten/{id}', [UrlController::class, 'updateUrl']);
        Route::delete('/{id}', [UrlController::class, 'deleteUrl']);
        Route::put('/{id}/toggleStatus', [UrlController::class, 'toggleStatus']);
    });

    Route::put('user/upgrade-plan', [UserController::class, 'upgradePlan']);
});
