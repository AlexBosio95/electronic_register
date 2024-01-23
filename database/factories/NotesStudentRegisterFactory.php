<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotesStudentRegister>
 */
class NotesStudentRegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teachers = Teacher::all();
        $students = Student::all();
        return [
            'student_id' => $this->faker->numberBetween(1,count($students)),
            'teacher_id' => $this->faker->numberBetween(1,count($teachers)),
            'data' => $this->faker->date(),
            'note' => $this->faker->sentence()
        ];
    }
}
