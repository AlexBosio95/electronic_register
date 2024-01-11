<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class TeacherClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $classes = Classe::all();
        foreach($teachers as $teacher){
            for($i=0; $i < 5; $i++){
                $classe = $classes->random();
                if(!in_array($classe, $teacher->classes()->get()->toArray()) && !in_array($teacher, $classe->teachers()->get()->toArray())){
                    $teacher->classes()->syncWithoutDetaching($classe);
                }
            }
        }
    }
}
