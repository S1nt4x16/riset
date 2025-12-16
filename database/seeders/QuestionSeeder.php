<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama agar id urut dari 1 (optional, tapi good for dev)
        // Disable foreign key checks for questions to avoid issues if answers refer to them
        \Schema::disableForeignKeyConstraints();
        Question::truncate();
        \Schema::enableForeignKeyConstraints();

        $questions = [
            // Karakteristik Responden
            [
                'text' => 'Jenis kelamin',
                'type' => 'radio',
                'key' => null,
                'options' => ['Pria', 'Wanita']
            ],
            [
                'text' => 'Usia',
                'type' => 'number',
                'key' => null,
                'options' => null
            ],
            [
                'text' => 'Fakultas',
                'type' => 'select',
                'key' => 'faculty',
                'options' => [] // Loaded dynamically
            ],
            [
                'text' => 'Program Studi',
                'type' => 'select',
                'key' => 'prodi',
                'options' => [] // Loaded dynamically based on Faculty
            ],
            [
                'text' => 'Jenjang studi',
                'type' => 'select',
                'key' => 'degree',
                'options' => [] // Loaded dynamically based on Prodi
            ],
            [
                'text' => 'Tahun belajar',
                'type' => 'select',
                'key' => null,
                'options' => ['Tahun ke-1', 'Tahun ke-2', 'Tahun ke-3', 'Tahun ke-4', 'Tahun ke-5', 'Lebih dari 5 tahun']
            ],
            [
                'text' => 'IP / IPK (Contoh: 3.50)',
                'type' => 'number', // Changed to number to match logic in view
                'key' => null,
                'options' => null
            ],
            [
                'text' => 'Tempat tinggal',
                'type' => 'select',
                'key' => null,
                'options' => ['Kos', 'Rumah orang tua', 'Asrama', 'Kontrakan', 'Apartemen', 'Lainnya']
            ],

            // Pengalaman Selama Kuliah
            [
                'text' => 'Selama kuliah, apakah pernah mengalami diskriminasi?',
                'type' => 'radio',
                'key' => null,
                'options' => ['Ya', 'Tidak']
            ],
            [
                'text' => 'Frekuensi olahraga dalam satu minggu',
                'type' => 'radio',
                'key' => null,
                'options' => ['Tidak pernah', '1–2 kali', '3–4 kali', '> 4 kali']
            ],

            // Kesehatan Mental & Stres
            [
                'text' => 'Apakah pernah merasa stres selama menjalani perkuliahan?',
                'type' => 'radio',
                'key' => null,
                'options' => ['Ya', 'Tidak']
            ],
            [
                'text' => 'Sumber stres yang dialami (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'key' => null,
                'options' => ['Akademik', 'Keuangan', 'Keluarga', 'Sosial', 'Lainnya']
            ],
            [
                'text' => 'Dampak stres yang dirasakan (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'key' => null,
                'options' => ['Sulit tidur', 'Cemas', 'Mudah lelah', 'Sulit konsentrasi', 'Emosi tidak stabil']
            ],

            // Strategi Koping / Cara Mengatasi Stres
            [
                'text' => 'Cara yang biasa dilakukan untuk mengurangi stres (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'key' => null,
                'options' => ['Kegiatan kreatif (menggambar, menulis jurnal, dll)', 'Hobi menyenangkan (membaca, berkebun, menonton, dll)', 'Interaksi sosial (berbicara dengan teman, komunitas)', 'Perawatan diri (tidur cukup, mandi air hangat, dll)', 'Lainnya']
            ],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
