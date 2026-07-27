<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_students' => Student::count(),
                'total_departments' => Department::count(),
                'active_students' => Student::active()->count(),
                'average_gpa' => Student::avg('gpa'),
            ],
        ]);
    }
}