<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyApiController;

Route::prefix('properties')->group(function () {
    Route::get('/', [PropertyApiController::class, 'index']);
});
