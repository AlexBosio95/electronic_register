<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabella che contiene tutti gli studenti.
     * C'è una relazione con la tabella delle classi per definire a quale classe appartiene ogni studente.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('surname', 60);
            $table->date('birthday');
            $table->string('address', 100);
            $table->string('city', 80);
            $table->unsignedBigInteger('class_id'); 
            $table->foreign('class_id')->references('id')->on('classes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
