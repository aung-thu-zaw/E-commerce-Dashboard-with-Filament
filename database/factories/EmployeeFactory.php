<?php

namespace Database\Factories;

use App\Models\EmployeePosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = EmployeePosition::pluck("id")->toArray();

        return [
            "employee_position_id" => fake()->randomElement($positions),
            "image" => fake()->imageUrl(),
            "name" => fake()->name("male"),
            "email" => fake()->unique()->email(),
            "phone" => fake()->unique()->phoneNumber(),
            "address" => fake()->address(),
            "experience" => fake()->randomElement(["6 months","1 year","2 years","5 years"]),
            "salary" => fake()->numberBetween(1000, 10000),
            "vacation" => fake()->randomElement(["sunday","monday","tuesday","wednesday","thursday","friday","saturday"]),
            "status" => fake()->randomElement(["active","inactive"]),
            "date_of_birth" => fake()->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
            "joining_date" => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
        ];
    }
}
