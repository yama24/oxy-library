<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $publisher = [
            'Gramedia',
            'Mizan',
            'Erlangga',
            'Republika',
        ];
        return [
            'user_id' => 1,
            'title' => fake()->sentence(mt_rand(2, 5)),
            'cover' => 'dummy.png',
            'author' => fake()->name(),
            'publisher' => $publisher[mt_rand(0, 3)],
            'printing_date' => fake()->dateTimeBetween('2021-01-01', '2021-12-31'),
        ];
    }
}
