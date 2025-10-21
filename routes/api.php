<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;

// Open routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Beveiligde routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Eerst de “speciale” book routes
    Route::get('books/trashed', [BookController::class, 'trashed']);
    Route::patch('books/{book}/restore', [BookController::class, 'restore']);

    // Daarna pas de resource
    Route::apiResource('books', BookController::class);

    Route::apiResource('genres', GenreController::class);
    Route::apiResource('authors', AuthorController::class);
});
