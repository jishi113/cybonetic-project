<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'department_id' => Department::inRandomOrder()->first()->id ?? 1,
            'roll_number' => strtoupper($this->faker->bothify('??####')),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->numerify('##########'),
            'gpa' => $this->faker->randomFloat(2, 5.0, 10.0),
            'year_of_study' => $this->faker->numberBetween(1, 4),
            'is_active' => true,
        ];
    }
}