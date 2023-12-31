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
        Schema::create('teacher_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id'); 
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->unsignedBigInteger('class_id'); 
            $table->foreign('class_id')->references('id')->on('classes');
            $table->primary(['teacher_id', 'class_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_classes');
    }
};
