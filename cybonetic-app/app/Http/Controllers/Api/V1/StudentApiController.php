<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $students = Student::with('department')
            ->when($request->search, function ($q) use ($request) {
                return $q->where('first_name', 'like', "%{$request->search}%")
                         ->orWhere('last_name', 'like', "%{$request->search}%")
                         ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->when($request->department_id, function ($q) use ($request) {
                return $q->where('department_id', $request->department_id);
            })
            ->when($request->min_gpa, function ($q) use ($request) {
                return $q->where('gpa', '>=', $request->min_gpa);
            })
            ->orderBy($request->sort_by ?? 'last_name')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => StudentResource::collection($students->items()),
            'meta' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
            ],
        ]);
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $student = Student::create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Student created successfully.',
            'data' => new StudentResource($student->load('department')),
        ], 201);
    }

    public function show(Student $student): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new StudentResource($student->load(['department', 'courses'])),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $student->update($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => new StudentResource($student->fresh('department')),
        ]);
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.',
        ]);
    }
}