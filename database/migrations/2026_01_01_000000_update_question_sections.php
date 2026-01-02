<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // A. Data Diri (1-7)
        DB::table('questions')
            ->whereBetween('id', [1, 7])
            ->update(['section' => 'A. Data Diri']);

        // B. Kesehatan & Gaya Hidup (8-10)
        DB::table('questions')
            ->whereBetween('id', [8, 10])
            ->update(['section' => 'B. Kesehatan & Gaya Hidup']);

        // C. Akademik & Finansial (11-14)
        DB::table('questions')
            ->whereBetween('id', [11, 14])
            ->update(['section' => 'C. Akademik & Finansial']);

        // D. Kesehatan Mental (15-20)
        DB::table('questions')
            ->whereBetween('id', [15, 20])
            ->update(['section' => 'D. Kesehatan Mental']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('questions')->update(['section' => null]);
    }
};
