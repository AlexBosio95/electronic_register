<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\User;
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
        $classes = Classe::all();
        $users = User::all();
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'birthday' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'class_id' => $this->faker->numberBetween(1, count($classes)),
            'user_id' => $this->faker->unique()->numberBetween(1, (count($users)-50)),  //tenere conto che dovranno essere unici
            'contact' => $this->faker->phoneNumber,
            'contact2' => $this->faker->phoneNumber 
        ];
    }
}
