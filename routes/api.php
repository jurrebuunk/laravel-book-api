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

    Route::apiResource('books', BookController::class);
    Route::get('books/trashed', [BookController::class, 'trashed']);
    Route::patch('books/{id}/restore', [BookController::class, 'restore']);

    Route::apiResource('genres', GenreController::class);

    Route::apiResource('authors', AuthorController::class);
});
