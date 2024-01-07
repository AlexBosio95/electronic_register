<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabella che contiene tutti i professori,
     * Sono presenti due relazioni con le tabelle classes e subjects, per definire quali materie insegnano e quali classi hanno
     * Ci saranno due tabelle pivot per definire le due relazioni
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('surname', 60);
            $table->date('birthday');
            $table->string('address', 100);
            $table->string('city', 80);
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
