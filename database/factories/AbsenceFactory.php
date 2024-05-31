<?php

namespace Database\Factories;

use App\Models\Absence;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $students = Student::all();

        return [
            'student_id' => $this->faker->numberBetween(1,count($students)),
            'date' => $this->faker->date(),
            'reason' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
