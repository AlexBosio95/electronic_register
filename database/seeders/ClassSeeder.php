<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            'Prima A Liceo Scientifico',
            'Prima B Liceo Scientifico',
            'Seconda A Liceo Scientifico',
            'Terza A Liceo Scientifico',
            'Quarta A Liceo Scientifico',
            'Quinta A Liceo Scientifico',
            'Prima A Liceo Classico',
            'Prima B Liceo Classico',
            'Prima C Liceo Classico',
            'Seconda A Liceo Classico',
            'Terza A Liceo Classico',
            'Quarta A Liceo Classico',
            'Quinta A Liceo Classico',
            'Prima A Liceo Linguistico',
            'Prima B Liceo Linguistico',
            'Seconda A Liceo Linguistico',
            'Terza A Liceo Linguistico',
            'Quarta A Liceo Linguistico',
            'Quinta A Liceo Linguistico',
            'Prima A Liceo Linguistico',
            'Prima B Liceo Linguistico',
            'Seconda A Liceo Linguistico',
            'Terza A Liceo Linguistico',
            'Quarta A Liceo Linguistico',
            'Quinta A Liceo Linguistico',
            'Prima A Ragioneria',
            'Seconda A Ragioneria',
            'Terza A Ragioneria',
            'Quarta A Ragioneria',
            'Quinta A Ragioneria',
        ];
        foreach ($events as $event) {
            Classe::create(['name' => $event]);
        }
    }
}
