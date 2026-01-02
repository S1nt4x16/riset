<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        \Schema::disableForeignKeyConstraints();
        Question::truncate();
        \Schema::enableForeignKeyConstraints();

        $questions = [
            // --- SECTION A: DATA DIRI ---
            // 1. Gender
            [
                'section' => 'A. Data Diri',
                'text' => 'Jenis kelamin',
                'type' => 'radio',
                'key' => null,
                'description' => null,
                'options' => ['Pria', 'Wanita']
            ],
            // 2. Usia
            [
                'section' => 'A. Data Diri',
                'text' => 'Usia',
                'type' => 'number',
                'key' => null,
                'description' => null,
                'options' => null
            ],
            // 3. Fakultas
            [
                'section' => 'A. Data Diri',
                'text' => 'Fakultas',
                'type' => 'select',
                'key' => 'faculty', // Dynamic options from DB
                'description' => null,
                'options' => [] 
            ],
            // 4. Prodi (Jenjang) - Combined
            [
                'section' => 'A. Data Diri',
                'text' => 'Program Studi (Jenjang)',
                'type' => 'select',
                'key' => 'prodi_degree', // Special key for combined logic
                'description' => 'Sesuai dengan fakultas yang dipilih',
                'options' => []
            ],
            // 5. Tahun Belajar
            [
                'section' => 'A. Data Diri',
                'text' => 'Tahun belajar',
                'type' => 'select',
                'key' => null,
                'description' => null,
                'options' => [
                    'Tahun pertama (Semester 1 atau 2)',
                    'Tahun kedua (Semester 3 atau 4)',
                    'Tahun ketiga (Semester 5 atau 6)',
                    'Tahun keempat (Semester 7 atau 8)',
                    'Angkatan senior (semester 9 dan lebih)'
                ]
            ],
            // 6. IPK
            [
                'section' => 'A. Data Diri',
                'text' => 'IPK',
                'type' => 'number',
                'key' => null,
                'description' => 'Isi dengan desimal, maksimal 4.00',
                'options' => null
            ],
            // 7. Tempat Tinggal
            [
                'section' => 'A. Data Diri',
                'text' => 'Tempat tinggal',
                'type' => 'select',
                'key' => null,
                'description' => null,
                'options' => [
                    'Kos dekat kampus (0-3 km)',
                    'Rumah Dekat Kampus (0-3 km)',
                    'Pulang-Pergi (lebih dari 3 km)'
                ]
            ],

            // --- SECTION B: KESEHATAN & GAYA HIDUP ---
            // 8. Diskriminasi
            [
                'section' => 'B. Kesehatan & Gaya Hidup',
                'text' => 'Apakah selama kuliah pernah mengalami diskriminasi?',
                'type' => 'radio',
                'key' => null,
                'description' => null,
                'options' => ['Ya', 'Tidak']
            ],
            // 9. Olahraga
            [
                'section' => 'B. Kesehatan & Gaya Hidup',
                'text' => 'Frekuensi olahraga per pekan?',
                'type' => 'radio',
                'key' => null,
                'description' => null,
                'options' => [
                    'Tidak sama sekali',
                    '1-3 kali',
                    '3-7 kali',
                    'Lebih dari 7 kali'
                ]
            ],
            // 10. Tidur
            [
                'section' => 'B. Kesehatan & Gaya Hidup',
                'text' => 'Durasi tidur per hari?',
                'type' => 'radio',
                'key' => null,
                'description' => null,
                'options' => [
                    'Kurang dari 4 jam',
                    '4 - 6 jam',
                    '6 - 8 jam',
                    'Lebih dari 8 jam'
                ]
            ],

            // --- SECTION C: AKADEMIK & FINANSIAL ---
            // 11. Pengalaman Akademis
            [
                'section' => 'C. Akademik & Finansial',
                'text' => 'Pengalaman akademis',
                'type' => 'radio',
                'key' => null,
                'description' => null,
                'options' => [
                    'Sangat Tidak menyenangkan',
                    'Tidak menyenangkan',
                    'Cukup menyenangkan',
                    'Menyenangkan',
                    'Sangat menyenangkan'
                ]
            ],
            // 12. Beban Akademis
            [
                'section' => 'C. Akademik & Finansial',
                'text' => 'Beban Akademis',
                'type' => 'radio',
                'key' => null,
                'description' => 'Beban kerja akademik mencakup semua kelas terjadwal dan waktu belajar untuk tugas, proyek, dan ujian.',
                'options' => [
                    'Sangat padat',
                    'Padat',
                    'Cukup padat',
                    'Santai',
                    'Sangat Santai'
                ]
            ],
            // 13. Tekanan Akademis
            [
                'section' => 'C. Akademik & Finansial',
                'text' => 'Tekanan akademis',
                'type' => 'radio',
                'key' => null,
                'description' => 'Stres dan kecemasan yang dirasakan mahasiswa ketika berusaha memenuhi ekspektasi akademik yang tinggi.',
                'options' => [
                    'Tertekan',
                    'Cukup tertekan',
                    'Tenang',
                    'Sangat tenang'
                ]
            ],
            // 14. Kekhawatiran Finansial
            [
                'section' => 'C. Akademik & Finansial',
                'text' => 'Kekhawatiran finansial',
                'type' => 'radio',
                'key' => null,
                'description' => 'Kekhawatiran tentang kecukupan biaya hidup dan biaya kuliah.',
                'options' => [
                    'Khawatir',
                    'Cukup aman',
                    'Aman',
                    'Sangat aman'
                ]
            ],

            // --- SECTION D: KESEHATAN MENTAL ---
            // 15. Hubungan Sosial
            [
                'section' => 'D. Kesehatan Mental',
                'text' => 'Hubungan sosial antara keluarga dan pertemanan',
                'type' => 'radio',
                'key' => null,
                'description' => null,
                'options' => [
                    'Sangat tidak akur',
                    'Tidak akur',
                    'Cukup akur',
                    'Akur',
                    'Sangat akur'
                ]
            ],
            // 16. Depresi
            [
                'section' => 'D. Kesehatan Mental',
                'text' => 'Depresi',
                'type' => 'radio',
                'key' => null,
                'description' => 'Mengalami suasana hati dengan perasaan sedih dan kehilangan minat yang terus-menerus, yang memengaruhi pikiran, perasaan, dan aktivitas sehari-hari seseorang.',
                'options' => [
                    'Sesuai',
                    'Cukup tidak sesuai',
                    'Tidak sesuai',
                    'Sangat tidak sesuai'
                ]
            ],
            // 17. Anxiety
            [
                'section' => 'D. Kesehatan Mental',
                'text' => 'Anxiety',
                'type' => 'radio',
                'key' => null,
                'description' => 'Mengalami keadaan gejolak batin yang tidak mengenakkan dan meliputi perasaan takut terhadap kejadian yang diantisipasi terutama nilai perkuliahan.',
                'options' => [
                    'Sesuai',
                    'Cukup tidak sesuai',
                    'Tidak sesuai',
                    'Sangat tidak sesuai'
                ]
            ],
            // 18. Isolation
            [
                'section' => 'D. Kesehatan Mental',
                'text' => 'Isolation',
                'type' => 'radio',
                'key' => null,
                'description' => 'Mengalami kurangnya kontak sosial yang hampir atau sepenuhnya.',
                'options' => [
                    'Sesuai',
                    'Cukup tidak sesuai',
                    'Tidak sesuai',
                    'Sangat tidak sesuai'
                ]
            ],
            // 19. Future Insecurity
            [
                'section' => 'D. Kesehatan Mental',
                'text' => 'Future Insecurity',
                'type' => 'radio',
                'key' => null,
                'description' => 'Merasa cemas atau ragu tentang kejadian yang akan datang, sering kali berasal dari ketidakpastian, pengalaman negatif di masa lalu, atau tekanan masyarakat.',
                'options' => [
                    'Cukup tidak sesuai',
                    'Tidak sesuai',
                    'Sangat tidak sesuai'
                ]
            ],
            // 20. Stress Release (Multi-select)
            [
                'section' => 'D. Kesehatan Mental',
                'text' => 'Stress Release (Boleh pilih lebih dari satu)',
                'type' => 'checkbox',
                'key' => null,
                'description' => 'Kegiatan yang dilakukan untuk mengurangi atau meredakan stres, baik stres fisik maupun emosional.',
                'options' => [
                    'Teknik relaksasi: meditasi, pernapasan dalam (deep breathing), mindfulness.',
                    'Kegiatan kreatif: menggambar, menulis jurnal, bermain musik.',
                    'Hobi yang menyenangkan: membaca, berkebun, memasak.',
                    'Interaksi sosial: berbicara dengan teman, bergaul dengan keluarga.',
                    'Perawatan diri: mandi air hangat, tidur cukup, pijat.',
                    'Lainnya' // Will trigger text input in view
                ]
            ],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
