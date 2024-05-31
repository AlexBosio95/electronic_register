<?php

namespace Database\Seeders;

use App\Models\GradesStudentRegister;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradesStudentRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradesStudentRegister::factory(100)->create();
    }
}
