<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['name' => 'Data Structures', 'code' => 'CS201', 'credits' => 4],
            ['name' => 'Database Systems', 'code' => 'CS301', 'credits' => 4],
            ['name' => 'Operating Systems', 'code' => 'CS401', 'credits' => 3],
            ['name' => 'Network Security', 'code' => 'IT401', 'credits' => 3],
            ['name' => 'Web Technologies', 'code' => 'IT301', 'credits' => 4],
            ['name' => 'Machine Learning', 'code' => 'CS501', 'credits' => 4],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['code' => $course['code']], $course);
        }
    }
}