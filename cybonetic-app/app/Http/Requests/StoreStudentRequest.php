<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'roll_number' => ['required', 'string', 'max:20', 'unique:students'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:150', 'unique:students'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'year_of_study' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.exists' => 'Please select a valid department.',
            'roll_number.unique' => 'This roll number is already registered.',
            'email.unique' => 'An account with this email already exists.',
            'gpa.max' => 'GPA cannot exceed 10.0.',
        ];
    }
}