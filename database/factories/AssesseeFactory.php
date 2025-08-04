<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Entity;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessee>
 */
class AssesseeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'band' => $this->faker->randomElement(['I', 'II', 'III', 'IV', 'V']),
            'entity_id' => Entity::all()->random()->id,
            'assessee_type' => $this->faker->randomElement(['Internal', 'Eksternal']),
        ];
    }
}
