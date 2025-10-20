<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'description' => 'The first book in the Harry Potter series.',
            'genre_id' => 1,
            'author_id' => 1,
            'publication_date' => '1997-06-26'
        ]);

        Book::create([
            'title' => 'A Game of Thrones',
            'description' => 'The first book in A Song of Ice and Fire.',
            'genre_id' => 1,
            'author_id' => 2,
            'publication_date' => '1996-08-06'
        ]);

        Book::create([
            'title' => 'The Fellowship of the Ring',
            'description' => 'The first book of The Lord of the Rings trilogy.',
            'genre_id' => 1,
            'author_id' => 3,
            'publication_date' => '1954-07-29'
        ]);
    }
}
