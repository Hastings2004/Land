<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plot>
 */
class PlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'area_sqm' => $this->faker->numberBetween(100, 10000),
            'location' => $this->faker->address,
            'status' => $this->faker->randomElement(['available', 'sold', 'reserved']),
            'is_new_listing' => $this->faker->boolean(30),
        ];
    }
}
