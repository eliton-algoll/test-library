<?php

namespace Database\Factories;

use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookAuthor>
 */
class BookAuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'livro_codL' => fake()->unique()->randomNumber(5),
            'autor_codAu' => fake()->unique()->randomNumber(5),
        ];
    }
}
