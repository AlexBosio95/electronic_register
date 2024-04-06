<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GradeOption;

class GradeOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            'insufficiente',
            'sufficiente',
            'buono',
            'distinto',
            'ottimo',
        ];

        foreach ($grades as $grade) {
            GradeOption::create([
                'name' => $grade,
            ]);
        }
    }
}
