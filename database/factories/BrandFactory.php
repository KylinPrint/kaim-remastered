<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->unique()->company,
            'subname'       => \Faker\Factory::create('en_US')->optional(0.7)->company,
            'created_at'    => $this->faker->dateTimeBetween('-1 year', '-1 month'),
            'updated_at'    => $this->faker->dateTimeBetween('-1 month'),
        ];
    }
}
