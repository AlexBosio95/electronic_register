<?php

namespace Database\Seeders;

use App\Models\AttendStudentRegister;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendStudentRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendStudentRegister::factory(100)->create();
    }
}
