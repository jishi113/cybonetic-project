<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CS', 'description' => 'Core CS program'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'IT and networking'],
            ['name' => 'Electronics', 'code' => 'EC', 'description' => 'Electronics engineering'],
            ['name' => 'Mechanical', 'code' => 'ME', 'description' => 'Mechanical engineering'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }
    }
}