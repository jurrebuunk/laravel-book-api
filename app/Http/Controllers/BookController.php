<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="API Endpoints for Books"
 * )
 */
class BookController extends Controller
{
    use SoftDeletes;

    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Get list of books",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of books per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for book titles",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Sort by column (title or publication_date)",
     *         required=false,
     *         @OA\Schema(type="string", default="title")
     *     ),
     *     @OA\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="Sort order (asc or desc)",
     *         required=false,
     *         @OA\Schema(type="string", default="asc")
     *     ),
     *     @OA\Parameter(
     *         name="genres",
     *         in="query",
     *         description="Filter by genre IDs (comma-separated, max 4)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of books",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","genre_id","author_id"},
     *             @OA\Property(property="title", type="string", example="Harry Potter"),
     *             @OA\Property(property="description", type="string", example="Fantasy novel"),
     *             @OA\Property(property="genre_id", type="integer", example=1),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="publication_date", type="string", format="date", example="2000-07-08")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/books/{book}",
     *     tags={"Books"},
     *     summary="Get a single book",
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Book details", @OA\JsonContent(ref="#/components/schemas/Book")),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
    public function show(Book $book)
    {
        return $book->load(['genre', 'author']);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{book}",
     *     tags={"Books"},
     *     summary="Update a book",
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="genre_id", type="integer"),
     *             @OA\Property(property="author_id", type="integer"),
     *             @OA\Property(property="publication_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Book updated", @OA\JsonContent(ref="#/components/schemas/Book")),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/books/{book}",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Book deleted"),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }

    /**
     * @OA\Get(
     *     path="/api/books/trashed",
     *     tags={"Books"},
     *     summary="Get soft deleted books",
     *     @OA\Response(response=200, description="List of trashed books", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book")))
     * )
     */
    public function trashed()
    {
        return Book::onlyTrashed()->with(['genre', 'author'])->get();
    }

    /**
     * @OA\Patch(
     *     path="/api/books/{id}/restore",
     *     tags={"Books"},
     *     summary="Restore a soft deleted book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Book restored", @OA\JsonContent(ref="#/components/schemas/Book")),
     *     @OA\Response(response=404, description="Book not found")
     * )
     */
    public function restore($book)
    {
        $book = Book::onlyTrashed()->findOrFail($book);
        $book->restore();
        return $book->load(['genre', 'author']);
    }
}
