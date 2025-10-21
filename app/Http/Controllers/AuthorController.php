<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Authors",
 *     description="API Endpoints for Authors"
 * )
 */
class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Get list of authors",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of authors per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of authors",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return response()->json(Author::paginate($perPage));
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Create a new author",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="J.K. Rowling"),
     *             @OA\Property(property="bio", type="string", example="Author of Harry Potter series")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author = Author::create($request->all());

        return response()->json($author, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{author}",
     *     tags={"Authors"},
     *     summary="Get a single author",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author details",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(response=404, description="Author not found")
     * )
     */
    public function show(Author $author)
    {
        return response()->json($author);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{author}",
     *     tags={"Authors"},
     *     summary="Update an author",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="bio", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(response=404, description="Author not found")
     * )
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author->update($request->all());

        return response()->json($author);
    }

    /**
     * @OA\Delete(
     *     path="/api/authors/{author}",
     *     tags={"Authors"},
     *     summary="Delete an author",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Author deleted"),
     *     @OA\Response(response=404, description="Author not found")
     * )
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
