<?php

namespace App\Actions\Admin\Employees;

use App\Http\Traits\ImageUpload;
use App\Models\Employee;
use Spatie\Permission\Models\Role;

class CreateEmployeeAction
{
    use ImageUpload;

    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): Employee
    {
        $image = isset($data['image']) ? $this->createImage($data['image'], 'employees') : null;

        $employee = Employee::create([
            'employee_position_id' => $data['employee_position_id'],
            'image' => $image,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'experience' => $data['experience'],
            'salary' => $data['salary'],
            'vacation' => $data['vacation'] ?? null,
            'status' => $data['status'],
            'date_of_birth' => $data['date_of_birth'],
            'joining_date' => $data['joining_date'],
            'termination_date' => $data['termination_date'] ?? null,
        ]);
        return $employee;
    }
}
