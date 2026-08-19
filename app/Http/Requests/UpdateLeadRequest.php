<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['nullable', 'exists:companies,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:200'],
            'contact_name' => ['required', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'source' => ['required', 'in:website,referral,cold_call,social,event,other'],
            'status' => ['required', 'in:' . implode(',', array_keys(Lead::STATUSES))],
            'value' => ['nullable', 'numeric', 'min:0'],
            'expected_close' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'lost_reason' => ['nullable', 'string', 'max:255'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
        ];
    }
}