<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama agar id urut dari 1 (optional, tapi good for dev)
        Question::truncate();

        $questions = [
            // Karakteristik Responden
            [
                'text' => 'Jenis kelamin',
                'type' => 'radio',
                'options' => ['Pria', 'Wanita']
            ],
            [
                'text' => 'Usia',
                'type' => 'number',
                'options' => null
            ],
            [
                'text' => 'Jenjang studi',
                'type' => 'select',
                'options' => ['D3', 'S1', 'S2', 'S3', 'Profesi', 'Spesialis']
            ],
            [
                'text' => 'Fakultas',
                'type' => 'select',
                'options' => [
                    'Ekonomi dan Bisnis',
                    'Kedokteran',
                    'Teknik',
                    'Ilmu Sosial dan Ilmu Politik',
                    'Ilmu Komputer',
                    'Hukum',
                    'Ilmu Kesehatan'
                ]
            ],
            [
                'text' => 'Tahun belajar',
                'type' => 'select',
                'options' => ['Tahun ke-1', 'Tahun ke-2', 'Tahun ke-3', 'Tahun ke-4', 'Tahun ke-5', 'Lebih dari 5 tahun']
            ],
            [
                'text' => 'IP / IPK (Contoh: 3.50)',
                'type' => 'text', // Text to allow decimals naturally or comma
                'options' => null
            ],
            [
                'text' => 'Tempat tinggal',
                'type' => 'select',
                'options' => ['Kos', 'Rumah orang tua', 'Asrama', 'Kontrakan', 'Apartemen', 'Lainnya']
            ],

            // Pengalaman Selama Kuliah
            [
                'text' => 'Selama kuliah, apakah pernah mengalami diskriminasi?',
                'type' => 'radio',
                'options' => ['Ya', 'Tidak']
            ],
            [
                'text' => 'Frekuensi olahraga dalam satu minggu',
                'type' => 'radio',
                'options' => ['Tidak pernah', '1–2 kali', '3–4 kali', '> 4 kali']
            ],

            // Kesehatan Mental & Stres
            [
                'text' => 'Apakah pernah merasa stres selama menjalani perkuliahan?',
                'type' => 'radio',
                'options' => ['Ya', 'Tidak']
            ],
            [
                'text' => 'Sumber stres yang dialami (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'options' => ['Akademik', 'Keuangan', 'Keluarga', 'Sosial', 'Lainnya']
            ],
            [
                'text' => 'Dampak stres yang dirasakan (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'options' => ['Sulit tidur', 'Cemas', 'Mudah lelah', 'Sulit konsentrasi', 'Emosi tidak stabil']
            ],

            // Strategi Koping / Cara Mengatasi Stres
            [
                'text' => 'Cara yang biasa dilakukan untuk mengurangi stres (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'options' => ['Kegiatan kreatif (menggambar, menulis jurnal, dll)', 'Hobi menyenangkan (membaca, berkebun, menonton, dll)', 'Interaksi sosial (berbicara dengan teman, komunitas)', 'Perawatan diri (tidur cukup, mandi air hangat, dll)', 'Lainnya']
            ],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
