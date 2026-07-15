<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        
        $students = Student::with('department')
            ->when($search, function ($query) use ($search) {
                return $query->where('first_name', 'like', "%$search%")
                             ->orWhere('last_name', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%")
                             ->orWhere('roll_number', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);
        
        return view('students.index', compact('students', 'search'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();
        return view('students.create', compact('departments'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $student = Student::create($request->validated());
        
        return redirect()
            ->route('students.show', $student)
            ->with('success', "Student created successfully!");
    }

    public function show(Student $student): View
    {
        $student->load('department');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        $departments = Department::orderBy('name')->get();
        return view('students.edit', compact('student', 'departments'));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());
        
        return redirect()
            ->route('students.show', $student)
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();
        
        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}