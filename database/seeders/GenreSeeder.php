<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        Genre::create(['name' => 'Fantasy']);
        Genre::create(['name' => 'Science Fiction']);
        Genre::create(['name' => 'Mystery']);
        Genre::create(['name' => 'Romance']);
    }
}
