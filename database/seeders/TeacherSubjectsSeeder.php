<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        foreach($teachers as $teacher){
            for($i=0; $i < 5; $i++){
                $subject = $subjects->random();
                if(!in_array($subject, $teacher->subjects()->get()->toArray()) && !in_array($teacher, $subject->teachers()->get()->toArray())){
                    $teacher->subjects()->syncWithoutDetaching($subject);
                }
            }
        }
    }
}
