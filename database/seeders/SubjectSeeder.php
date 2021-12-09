<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [
                'grade_level' => 7,
                'subject_code' => 'FIL-07',
                'descriptive_title' => 'Filipino',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'ENG-07',
                'descriptive_title' => 'English',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'MATH-07',
                'descriptive_title' => 'Mathematics',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'SCI-07',
                'descriptive_title' => 'Science and Technology',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'AP-07',
                'descriptive_title' => 'Araling Panlipunan',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'EsP-07',
                'descriptive_title' => 'Edukasyon sa Pagpapakatao',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'TLE-07',
                'descriptive_title' => 'Technology and Livelihood Education',
                'subject_for' => 'BEC'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'MAPEH-07',
                'descriptive_title' => 'Music, Arts, Physical Education, and Health',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 7,
                'subject_code' => 'RSTE-07',
                'descriptive_title' => 'Research I',
                'subject_for' => 'STEM'
            ],
            //for grade 8
            [
                'grade_level' => 8,
                'subject_code' => 'FIL-08',
                'descriptive_title' => 'Filipino',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'ENG-08',
                'descriptive_title' => 'English',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'MATH-08',
                'descriptive_title' => 'Mathematics',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'SCI-08',
                'descriptive_title' => 'Science and Technology',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'AP-08',
                'descriptive_title' => 'Araling Panlipunan',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'EsP-08',
                'descriptive_title' => 'Edukasyon sa Pagpapakatao',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'TLE-08',
                'descriptive_title' => 'Technology and Livelihood Education',
                'subject_for' => 'BEC'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'MAPEH-08',
                'descriptive_title' => 'Music, Arts, Physical Education, and Health',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 8,
                'subject_code' => 'RSTE-08',
                'descriptive_title' => 'Research II',
                'subject_for' => 'STEM'
            ],

            //subject 9
            [
                'grade_level' => 9,
                'subject_code' => 'FIL-09',
                'descriptive_title' => 'Filipino',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'ENG-09',
                'descriptive_title' => 'English',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'MATH-09',
                'descriptive_title' => 'Mathematics',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'SCI-09',
                'descriptive_title' => 'Science and Technology',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'AP-09',
                'descriptive_title' => 'Araling Panlipunan',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'EsP-09',
                'descriptive_title' => 'Edukasyon sa Pagpapakatao',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'TLE-09',
                'descriptive_title' => 'Technology and Livelihood Education',
                'subject_for' => 'BEC'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'MAPEH-09',
                'descriptive_title' => 'Music, Arts, Physical Education, and Health',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 9,
                'subject_code' => 'RSTE-09',
                'descriptive_title' => 'Chemistry',
                'subject_for' => 'STEM'
            ],

            // suject for 10

            [
                'grade_level' => 10,
                'subject_code' => 'FIL-10',
                'descriptive_title' => 'Filipino',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'ENG-10',
                'descriptive_title' => 'English',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'MATH-10',
                'descriptive_title' => 'Mathematics',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'SCI-10',
                'descriptive_title' => 'Science and Technology',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'AP-10',
                'descriptive_title' => 'Araling Panlipunan',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'EsP-10',
                'descriptive_title' => 'Edukasyon sa Pagpapakatao',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'TLE-10',
                'descriptive_title' => 'Technology and Livelihood Education',
                'subject_for' => 'BEC'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'MAPEH-10',
                'descriptive_title' => 'Music, Arts, Physical Education, and Health',
                'subject_for' => 'GENERAL'
            ],
            [
                'grade_level' => 10,
                'subject_code' => 'RSTE-10',
                'descriptive_title' => 'Electronics and Robotics',
                'subject_for' => 'STEM'
            ],
        ];

        foreach ($subjects as $value) {
            Subject::create($value);
        }
    }
}
