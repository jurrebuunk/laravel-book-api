<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookController extends Controller
{
    // GET /api/books
    public function index()
    {
        return Book::with(['genre', 'author'])->get();
    }

    // POST /api/books
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id',
            'publication_date' => 'nullable|date',
        ]);

        return Book::create($validated);
    }

    // GET /api/books/{book}
    public function show(Book $book)
    {
        return $book->load(['genre', 'author']);
    }

    // PUT/PATCH /api/books/{book}
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id',
            'publication_date' => 'nullable|date',
        ]);

        $book->update($validated);
        return $book->load(['genre', 'author']);
    }

    // DELETE /api/books/{book}
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }

    // GET /api/books/trashed
    public function trashed()
    {
        return Book::onlyTrashed()->with(['genre', 'author'])->get();
    }

    // PATCH /api/books/{id}/restore
    public function restore($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();
        return $book->load(['genre', 'author']);
    }
}
