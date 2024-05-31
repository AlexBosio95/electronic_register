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
        Schema::table('grade_student_register', function (Blueprint $table) {
            $table->enum('type', ['mark', 'note'])->default('note')->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grade_student_register', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
