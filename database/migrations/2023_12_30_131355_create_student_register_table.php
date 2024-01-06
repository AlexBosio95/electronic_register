<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabella che rappresenta il registro studenti, cioè dove ci sono tutti i voti, note e presenze per ogni alunno
     * Tutte le foreign key si riferiscono infatti allo studente, al prof che ha registrato l'evento, la materia, il tipo di evento e
     * poi un campo note per definire effetivamente cosa contiene l'evento quindi nel caso di un voto 8, 4.5, 5/6, 9+
     * per le note ci sarà una frase del tipo "L'alunno, x y non si è comportato bene" o per le presenze, 0 o 1 rispettiavamente in caso
     * di assenza o presenza.
     */
    public function up(): void
    {
        Schema::create('student_register', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); 
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('teacher_id'); 
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->unsignedBigInteger('subject_id'); 
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->unsignedBigInteger('event_id'); 
            $table->foreign('event_id')->references('id')->on('events');
            $table->string('note', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_register');
    }
};
