<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            'Dalam sebulan terakhir, seberapa sering Anda merasa kesulitan menyeimbangkan antara kuliah dan kehidupan pribadi?',
            'Seberapa sering Anda merasa sulit berkonsentrasi saat belajar?',
            'Dalam sebulan terakhir, seberapa sering Anda merasa cemas berlebihan?',
            'Seberapa sering Anda merasa kurang tidur karena memikirkan tugas/ujian?',
            'Apakah Anda merasa mendapat cukup dukungan dari teman atau keluarga?',
            'Seberapa sering Anda merasa kehilangan motivasi untuk kuliah?',
            'Seberapa sering Anda merasa kewalahan oleh beban akademik?',
            'Seberapa sering Anda berpartisipasi dalam kegiatan kampus sosial dalam sebulan terakhir?',
            'Seberapa sering Anda merasa senang dengan hasil yang dicapai di perkuliahan?',
            'Apakah Anda tahu layanan konseling kampus jika membutuhkan bantuan?'
        ];

        foreach ($questions as $text) {
            Question::create(['text' => $text]);
        }
    }
}
