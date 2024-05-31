<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GradeOption;

class GradeOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['name' => '1', 'value' => 1],
            ['name' => '2', 'value' => 2],
            ['name' => '3', 'value' => 3],
            ['name' => '4', 'value' => 4],
            ['name' => '5', 'value' => 5],
            ['name' => '5/6', 'value' => 5.5],
            ['name' => '6', 'value' => 6],
            ['name' => '6,5', 'value' => 6.5],
            ['name' => '7', 'value' => 7],
            ['name' => '8', 'value' => 8],
            ['name' => '9', 'value' => 9],
            ['name' => '10', 'value' => 10],
        ];

        DB::table('grade_options')->insert($grades);
    }
}
