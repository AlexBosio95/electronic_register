<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'birthday' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'user_id' => $this->faker->unique()->numberBetween(101, count($users)),  //tenere conto che dovranno essere unici
        ];
    }
}
