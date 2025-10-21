<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;

// Open routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Me and logout
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        // Special book routes
        Route::get('books/trashed', [BookController::class, 'trashed']);
        Route::patch('books/{book}/restore', [BookController::class, 'restore']);

        // Full resources
        Route::apiResource('books', BookController::class);
        Route::apiResource('genres', GenreController::class);
        Route::apiResource('authors', AuthorController::class);
    });

    // User and admin read-only
    Route::middleware('role:admin|user')->group(function () {
        Route::get('books', [BookController::class, 'index']);
        Route::get('books/{book}', [BookController::class, 'show']);
    });

});
