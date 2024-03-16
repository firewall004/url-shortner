<?php

use App\Http\Controllers\SPAController;
use Illuminate\Support\Facades\Route;

Route::get('/{any}', [SPAController::class, 'index'])->where('any', '.*');
