<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Popola il database con 10 materie generati dalla factory
        //personalizzabile in base al corso
        $subjects = [
            'Matematica',
            'Italiano',
            'Storia',
            'Geografia',
            'Scienze',
            'Inglese',
            'Arte',
            'Educazione Fisica',
            'Scienze e tecnologie informatiche',
            'Tecnologia',
            'Arte e immagine',
            'Musica',
            'Topografia',
            'Latino',
            'Fisica',
            'Chimica',
            'Gestione cantieri',
            'Estimo',
            'Tedesco',
            'Greco'
        ];
        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
