<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Genres",
 *     description="API Endpoints for Genres"
 * )
 */

class GenreController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/genres",
     *     tags={"Genres"},
     *     summary="Get list of genres",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of genres per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of genres",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return Genre::paginate($perPage);
    }

    /**
     * @OA\Post(
     *     path="/api/genres",
     *     tags={"Genres"},
     *     summary="Create a new genre",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Fantasy")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Genre created",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        return Genre::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/genres/{genre}",
     *     tags={"Genres"},
     *     summary="Get a single genre",
     *     @OA\Parameter(
     *         name="genre",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Genre details",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     ),
     *     @OA\Response(response=404, description="Genre not found")
     * )
     */
    public function show(Genre $genre)
    {
        return $genre;
    }

    /**
     * @OA\Put(
     *     path="/api/genres/{genre}",
     *     tags={"Genres"},
     *     summary="Update a genre",
     *     @OA\Parameter(
     *         name="genre",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Fantasy Updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Genre updated",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     ),
     *     @OA\Response(response=404, description="Genre not found")
     * )
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $genre->update($validated);
        return $genre;
    }

    /**
     * @OA\Delete(
     *     path="/api/genres/{genre}",
     *     tags={"Genres"},
     *     summary="Delete a genre",
     *     @OA\Parameter(
     *         name="genre",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Genre deleted"),
     *     @OA\Response(response=404, description="Genre not found")
     * )
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->noContent();
    }
}
