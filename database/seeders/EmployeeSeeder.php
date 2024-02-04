<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory()->create(["employee_position_id" => 2,"image" => "chef-2.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 3,"image" => "chef-3.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 1,"image" => "chef-1.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 5,"image" => "chef-5.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 6,"image" => "chef-6.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 7,"image" => "chef-7.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 4,"image" => "chef-4.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 8,"image" => "chef-8.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 11,"image" => "chef-11.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 1,"image" => "chef-12.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 9,"image" => "chef-9.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 2,"image" => "chef-13.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 10,"image" => "chef-10.webp","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 3,"image" => "chef-14.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 4,"image" => "chef-15.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 5,"image" => "chef-16.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 8,"image" => "chef-19.png","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 6,"image" => "chef-17.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 10,"image" => "chef-20.jpeg","status" => "active"]);
        Employee::factory()->create(["employee_position_id" => 7,"image" => "chef-18.jpeg","status" => "active"]);

        Employee::factory(50)->create();
    }
}
