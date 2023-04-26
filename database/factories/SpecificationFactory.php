<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specification>
 */
class SpecificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->unique()->word,
            'category_id'   => $this->faker->numberBetween(4, 23),
            'required'      => $this->faker->randomElement([0, 1]),
            'created_at'    => $this->faker->dateTimeBetween('-25 day', '-10 day'),
            'updated_at'    => $this->faker->dateTimeBetween('-5 day'),
        ];
    }
}
