<?php

use App\Http\Controllers\SPAController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/short/{shortenedUrl}', [UrlController::class, 'redirectToOriginalUrl']);
Route::get('/{any}', [SPAController::class, 'index'])->where('any', '.*');
