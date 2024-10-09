<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codL' => fake()->unique()->randomNumber(5),
            'titulo' => fake()->sentence(40),
            'editora' => fake()->company(),
            'edicao' => fake()->numberBetween(1, 20),
            'anoPublicacao' => fake()->year(),
            'valor' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
