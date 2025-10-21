<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Welkom01'), // Will be hashed automatically
            'role' => 'admin',
        ]);

        // Optionally, create a normal user
        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        // Other seeders
        Author::factory(5)->create();
        Genre::factory(5)->create();
        Book::factory(20)->create();
    }
}
