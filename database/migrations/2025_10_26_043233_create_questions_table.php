<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('section')->nullable(); // A, B, C, D
            $table->text('text');
            $table->string('type')->default('radio'); // text, number, radio, checkbox, select
            $table->json('options')->nullable(); // Untuk menyimpan pilihan jawaban
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
