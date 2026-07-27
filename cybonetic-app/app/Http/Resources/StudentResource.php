<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'roll_number' => $this->roll_number,
            'name' => [
                'first' => $this->first_name,
                'last' => $this->last_name,
                'full' => $this->full_name,
            ],
            'email' => $this->email,
            'phone' => $this->phone,
            'gpa' => (float) $this->gpa,
            'year_of_study' => $this->year_of_study,
            'is_active' => (bool) $this->is_active,
            'department' => $this->whenLoaded('department', function () {
                return [
                    'id' => $this->department->id,
                    'name' => $this->department->name,
                    'code' => $this->department->code,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}