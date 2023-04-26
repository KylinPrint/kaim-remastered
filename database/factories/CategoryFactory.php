<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'parent_id'     => $this->faker->randomElement([1, 2, 3]),
            'title'         => $this->faker->unique()->word,
            'created_at'    => $this->faker->dateTimeBetween('-1 year', '-1 month'),
            'updated_at'    => $this->faker->dateTimeBetween('-1 month'),
        ];
    }
}
