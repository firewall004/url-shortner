<?php

use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'registerUser']);
Route::post('/login', [UserController::class, 'loginUser']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'getUserDetail']);
    Route::get('/logout', [UserController::class, 'logoutUser']);

    Route::prefix('urls')->group(function () {
        Route::get('/', [UrlController::class, 'getUserUrls']);
        Route::post('/shorten', [UrlController::class, 'shortenUrl']);
        Route::put('/shorten/{id}', [UrlController::class, 'updateUrl']);
        Route::delete('/{id}', [UrlController::class, 'deleteUrl']);
    });
});
