<?php

use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\MediaController;
use Illuminate\Support\Facades\Route;

Route::apiResource('media', MediaController::class);

// Custom actions untuk koleksi milik user.
Route::get('/users/{user}/collection', [CollectionController::class, 'index']);
Route::post('/users/{user}/collection/{media}', [CollectionController::class, 'store']);
Route::delete('/users/{user}/collection/{media}', [CollectionController::class, 'destroy']);
