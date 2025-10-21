<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookController extends Controller
{
    use SoftDeletes;

    // GET /api/books
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // standaard 10 per pagina
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'title'); // 'title' of 'publication_date'
        $sortOrder = $request->query('sort_order', 'asc'); // 'asc' of 'desc'
        $genreIds = $request->query('genres'); // kan een array of comma-separated string zijn

        $query = Book::with(['genre', 'author']);

        // Zoeken op titel
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filteren op genres
        if ($genreIds) {
            if (is_string($genreIds)) {
                $genreIds = explode(',', $genreIds);
            }
            $genreIds = array_slice($genreIds, 0, 4); // maximaal 4
            $query->whereIn('genre_id', $genreIds);
        }

        // Sorteren
        if (in_array($sortBy, ['title', 'publication_date']) && in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query->paginate($perPage);
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
    public function restore($book)
    {
        $book = Book::onlyTrashed()->findOrFail($book);
        $book->restore();
        return $book->load(['genre', 'author']);
    }
}
