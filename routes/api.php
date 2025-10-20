<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::apiResource('genres', GenreController::class);
Route::apiResource('books', BookController::class);

Route::get('books/trashed', [BookController::class, 'trashed']);
Route::patch('books/{id}/restore', [BookController::class, 'restore']);

Route::apiResource('authors', AuthorController::class);
