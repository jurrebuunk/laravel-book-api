<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     title="Author",
 *     required={"id","name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="J.K. Rowling"),
 *     @OA\Property(property="bio", type="string", example="Author of Harry Potter series"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-21T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-21T12:34:56Z")
 * )
 */


class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'bio'
    ];

    // Relatie met Book
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
