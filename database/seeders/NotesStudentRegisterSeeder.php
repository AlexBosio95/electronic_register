<?php

namespace Database\Seeders;

use App\Models\NotesStudentRegister;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotesStudentRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotesStudentRegister::factory(100)->create();
    }
}
