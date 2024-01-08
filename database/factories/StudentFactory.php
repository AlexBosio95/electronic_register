<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'birthday' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'class_id' => $this->faker->numberBetween(1, 30),
            'user_id' => $this->faker->unique()->numberBetween(1, 100),  //tenere conto che dovranno essere unici
        ];
    }
}
