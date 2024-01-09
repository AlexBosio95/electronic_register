<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outcomes = ['2','3','4','5','6','7','8','9','10'];
        $periods = ['intermediate', 'final'];

        $students = Student::all();
        $subjects = Subject::all();
        foreach ($students as $student){
            foreach ($subjects as $subject){
                foreach ($periods as $period){
                    Report::create(['student_id' => $student->id, 
                    'subject_id' => $subject->id, 
                    'period' => $period, 
                    'outcome' => $outcomes[array_rand($outcomes)]
                    ]);
                }
            }
        }
    }
}
