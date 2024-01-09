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
class StudentRegisterFactory extends Factory
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
        $subjects = Subject::all();
        $events = Event::all();
        return [
            'teacher_id' => $this->faker->numberBetween(1,count($teachers)),
            'student_id' => $this->faker->numberBetween(1,count($students)),
            'subject_id' => $this->faker->numberBetween(1,count($subjects)),
            'event_id' => $this->faker->numberBetween(1,count($events)),
            'note' => $this->faker->sentence()
        ];
    }
}
