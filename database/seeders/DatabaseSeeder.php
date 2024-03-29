<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(150)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            ClassSeeder::class, 
            SubjectSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            GradesStudentRegisterSeeder::class,
            NotesStudentRegisterSeeder::class,
            AttendStudentRegisterSeeder::class,
            TeacherRegisterSeeder::class,
            ReportSeeder::class,
            TeacherClassesSeeder::class,
            TeacherSubjectsSeeder::class,
            AbsenceSeeder::class,
            SchoolCalendarSeeder::class
        ]);
    }
}
