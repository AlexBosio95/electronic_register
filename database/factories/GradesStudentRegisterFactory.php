<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentRegister>
 */
class GradesStudentRegisterFactory extends Factory
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
        $subject = Subject::all();
        return [
            'subject_id' => $this->faker->numberBetween(1,count($subject)),
            'student_id' => $this->faker->numberBetween(1,count($students)),
            'teacher_id' => $this->faker->numberBetween(1,count($teachers)),
            'data' => $this->faker->date(),
            'note' => $this->faker->sentence()
        ];
    }
}
