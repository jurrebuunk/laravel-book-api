<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create([
            'name' => 'J.K. Rowling',
            'bio' => 'Author of the Harry Potter series'
        ]);

        Author::create([
            'name' => 'George R.R. Martin',
            'bio' => 'Author of A Song of Ice and Fire'
        ]);

        Author::create([
            'name' => 'J.R.R. Tolkien',
            'bio' => 'Author of The Lord of the Rings'
        ]);
    }
}
