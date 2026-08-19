<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'students' => Student::where('is_active', true)->count(),
            'departments' => Department::count(),
            'users' => User::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}