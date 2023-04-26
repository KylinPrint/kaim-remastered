<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peripheral>
 */
class PeripheralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{3}'),
            'brand_id'      => $this->faker->numberBetween(1, 50),
            'category_id'   => $this->faker->numberBetween(4, 23),
            'description'   => $this->faker->optional(0.7)->sentence,
            'created_at'    => $this->faker->dateTimeBetween('-25 day', '-10 day'),
            'updated_at'    => $this->faker->dateTimeBetween('-5 day'),
        ];
    }
}
