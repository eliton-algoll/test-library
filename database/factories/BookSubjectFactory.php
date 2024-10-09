<?php

namespace Database\Factories;

use App\Models\BookSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookSubject>
 */
class BookSubjectFactory extends Factory
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
            'assunto_codAu' => fake()->unique()->randomNumber(5),
        ];
    }
}
