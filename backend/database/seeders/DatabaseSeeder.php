<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create authors
        $authors = Author::factory(10)->create();

        // Create publishers
        $publishers = Publisher::factory(5)->create();

        // Create books distributed across authors and publishers
        Book::factory(30)->create([
            'author_id' => fn () => $authors->random()->id,
            'publisher_id' => fn () => $publishers->random()->id,
        ]);
    }
}
