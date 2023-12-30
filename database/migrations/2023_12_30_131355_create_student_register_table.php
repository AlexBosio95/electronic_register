<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
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
