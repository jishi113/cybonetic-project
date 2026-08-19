<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $departments = Department::orderBy('name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $departments,
        ]);
    }

    public function show(Department $department): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $department,
        ]);
    }
}