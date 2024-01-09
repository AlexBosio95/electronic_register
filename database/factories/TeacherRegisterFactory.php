<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherRegister>
 */
class TeacherRegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teachers = Teacher::all();
        $classes = Classe::all();
        $subjects = Subject::all();
        return [
            'teacher_id' => $this->faker->numberBetween(1,count($teachers)),
            'subject_id' => $this->faker->numberBetween(1,count($subjects)),
            'class_id' => $this->faker->numberBetween(1,count($classes)),
            'note' => $this->faker->sentence()
        ];
    }
}
