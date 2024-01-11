<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            'Mark',
            'Disciplinary note',
            'Attendance',
            'FirstHourLesson',
            'SecondHourLesson',
            'ThirdHourLesson',
            'FourthHourLesson',
            'FifthHourLesson'
        ];
        foreach ($events as $event) {
            Event::create(['name' => $event]);
        }
    }
}
