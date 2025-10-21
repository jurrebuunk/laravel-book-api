<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     title="Book",
 *     required={"title","genre_id","author_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Harry Potter"),
 *     @OA\Property(property="description", type="string", example="Fantasy novel"),
 *     @OA\Property(property="genre_id", type="integer", example=1),
 *     @OA\Property(property="author_id", type="integer", example=1),
 *     @OA\Property(property="publication_date", type="string", format="date", example="2000-07-08"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-21T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-21T12:00:00Z")
 * )
 */

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'genre_id',
        'author_id',
        'publication_date',
    ];

    // Relatie met Author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}

