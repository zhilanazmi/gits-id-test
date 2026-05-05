<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(2, 6)),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
            'isbn' => fake()->unique()->isbn13(),
            'description' => fake()->paragraph(5),
            'published_at' => fake()->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'pages' => fake()->numberBetween(50, 800),
        ];
    }
}
