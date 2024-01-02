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
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); 
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('subject_id'); 
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->enum('outcome', ['2', '3', '4','5', '6', '7','8', '9', '10']);
            $table->enum('period', ['intermediate', 'final']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report');
    }
};
