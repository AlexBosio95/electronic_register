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
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        static $index = 0;
        $day = $daysOfWeek[$index % count($daysOfWeek)];
        $index++;

        $timeStart = $this->faker->dateTimeBetween('08:00', '8:30')->format('H:i');
        $timeEnd = $this->faker->dateTimeBetween('13:00', '15:00')->format('H:i');

        return [
            'day_of_week' => $day,
            'time_start' => $timeStart,
            'time_end' => $timeEnd,
            'date_time_start' => $this->faker->date(),
            'date_time_end' => $this->faker->date(),
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'class_id' => Classe::inRandomOrder()->first()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
            'note' => $this->faker->sentence()
        ];
    }
}
