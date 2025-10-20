<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        return Genre::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        return Genre::create($validated);
    }

    public function show(Genre $genre)
    {
        return $genre;
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $genre->update($validated);
        return $genre;
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->noContent();
    }
}
