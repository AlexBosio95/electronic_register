<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolCalendar>
 */
class SchoolCalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        static $index = 0;
        $day = $daysOfWeek[$index % count($daysOfWeek)];
        $index++;

        return [
            'day_of_week' => $day,
            'time_start' => $this->faker->time('H:i'),
            'time_end' => $this->faker->time('H:i'),
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'class_id' => Classe::inRandomOrder()->first()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
        ];
    }
}
