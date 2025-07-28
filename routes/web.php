<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;


Route::group(['prefix' => 'property', 'as' => 'property.'], function () {
    Route::get('/', [PropertyController::class, 'index'])->name('index');
    Route::get('/create', [PropertyController::class, 'create'])->name('create');
    Route::post('/', [PropertyController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [PropertyController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PropertyController::class, 'update'])->name('update');
    Route::delete('/{id}', [PropertyController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/restore', [PropertyController::class, 'restore'])->name('restore');
});


Route::prefix('api/properties')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\PropertyController::class, 'index']);
});