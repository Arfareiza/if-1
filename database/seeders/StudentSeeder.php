<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'nim' => 'CONTOH001',
                'name' => 'Mahasiswa Contoh 1',
                'class_name' => 'IF 1',
                'bio' => 'Mahasiswa Teknik Informatika UNIKOM.',
            ],
            [
                'nim' => 'CONTOH002',
                'name' => 'Mahasiswa Contoh 2',
                'class_name' => 'IF 1',
                'bio' => 'Tertarik pada teknologi dan pemrograman.',
            ],
            [
                'nim' => 'CONTOH003',
                'name' => 'Mahasiswa Contoh 3',
                'class_name' => 'IF 1',
                'bio' => 'Sedang belajar mengembangkan aplikasi.',
            ],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['nim' => $student['nim']],
                $student
            );
        }
    }
}
