<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Registro professori in cui ogni prof scrive cosa fa in ogni classe.
     * Relazioni con tabelle materie e classi e note per scrivere cosa è stato effettivamente fatto
     */
    public function up(): void
    {
        Schema::create('teacher_register', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id'); 
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->unsignedBigInteger('subject_id'); 
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->unsignedBigInteger('class_id'); 
            $table->foreign('class_id')->references('id')->on('classes');
            $table->string('note', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_register');
    }
};
