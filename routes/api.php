<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/post_images', [PostImageController::class, 'store']);
    Route::post('/posts', [PostController::class, 'store']);
});
