<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Degree;
use App\Models\Prodi;

class AcademicSeeder extends Seeder
{
    public function run()
    {
        // Reset tables
        \Schema::disableForeignKeyConstraints();
        \DB::table('degree_prodi')->truncate();
        Prodi::truncate();
        Faculty::truncate();
        Degree::truncate();
        \Schema::enableForeignKeyConstraints();

        $data = [
            'Ekonomi dan Bisnis' => [
                'Perbankan & Keuangan' => ['D3'],
                'Akuntansi' => ['S2', 'S1', 'D3'],
                'Manajemen' => ['S2', 'S1'],
                'Ekonomi Pembangunan' => ['S1'],
                'Ekonomi Syariah' => ['S1'],
            ],
            'Kedokteran' => [
                'Kedokteran' => ['S1', 'Profesi (Dokter)'],
                'Farmasi' => ['S1', 'Profesi (Apoteker)'],
                'Radiologi' => ['Spesialis'],
                'Sains Biomedis' => ['S2'],
                'Biologi' => ['S1'],
            ],
            'Teknik' => [
                'Teknik Mesin' => ['S1'],
                'Teknik Industri' => ['S1'],
                'Teknik Perkapalan' => ['S1'],
                'Teknik Elektro' => ['S1'],
            ],
            'Ilmu Sosial & Ilmu Politik' => [
                'Ilmu Komunikasi' => ['S2', 'S1'],
                'Hubungan Internasional' => ['S2', 'S1'],
                'Ilmu Politik' => ['S2', 'S1'],
                'Sains Informasi' => ['S1'],
                'Kajian Film, Televisi dan Media' => ['S1'],
            ],
            'Ilmu Komputer' => [
                'Sistem Informasi' => ['S1', 'D3'],
                'Informatika' => ['S1'], // User text: "Informatika", image: "Informatika / Ilmu Komputer" ? 
                // User text lists "Informatika: S1". Image lists "Informatika / Ilmu Komputer".
                // I'll stick to user text from the prompt: "Informatika: S1"
                'Sains Data' => ['S1'],
            ],
            'Hukum' => [
                'Hukum' => ['S3', 'S2', 'S1'],
                'Hukum Bisnis' => ['S1'],
            ],
            'Ilmu Kesehatan' => [
                'Keperawatan' => ['S2', 'S1', 'D3', 'Profesi (Ners)'],
                'Kesehatan Masyarakat' => ['S2', 'S1'],
                'Fisioterapi' => ['S1', 'D3'],
                'Gizi' => ['S1'],
            ],
        ];

        foreach ($data as $facultyName => $prodis) {
            $faculty = Faculty::create(['name' => $facultyName]);
            
            foreach ($prodis as $prodiName => $degreeNames) {
                $prodi = Prodi::create([
                    'faculty_id' => $faculty->id,
                    'name' => $prodiName,
                ]);

                foreach ($degreeNames as $degreeName) {
                    $degree = Degree::firstOrCreate(['name' => $degreeName]);
                    $prodi->degrees()->attach($degree->id);
                }
            }
        }
    }
}
