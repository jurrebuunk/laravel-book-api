<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a specific test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Optional: create additional random users
        User::factory(5)->create();

        // Other data
        Author::factory(5)->create();
        Genre::factory(5)->create();
        Book::factory(20)->create();
    }
}
