<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeePosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeePosition::create(["name" => "Head Chef"]);
        EmployeePosition::create(["name" => "Sous Chef"]);
        EmployeePosition::create(["name" => "Line Chef"]);
        EmployeePosition::create(["name" => "Prep Chef"]);
        EmployeePosition::create(["name" => "Pastry Chef"]);
        EmployeePosition::create(["name" => "Executive Chef"]);
        EmployeePosition::create(["name" => "Chef de Chef"]);
        EmployeePosition::create(["name" => "Grill Chef"]);
        EmployeePosition::create(["name" => "Garde Manger Chef"]);
        EmployeePosition::create(["name" => "Saute Chef"]);
        EmployeePosition::create(["name" => "Banquet Chef"]);
        EmployeePosition::create(["name" => "Line Cook"]);
        EmployeePosition::create(["name" => "Prep Cook"]);
        EmployeePosition::create(["name" => "Restaurant Manager"]);
        EmployeePosition::create(["name" => "Assistant Manager"]);
        EmployeePosition::create(["name" => "Host/Hostess"]);
        EmployeePosition::create(["name" => "Server/Waiter/Waitress"]);
        EmployeePosition::create(["name" => "Bartender"]);
        EmployeePosition::create(["name" => "Busser/Runner"]);
        EmployeePosition::create(["name" => "Kitchen Manager"]);
        EmployeePosition::create(["name" => "Kitchen Supervisor"]);
        EmployeePosition::create(["name" => "Head Server"]);
        EmployeePosition::create(["name" => "Lead Waiter/Waitress"]);
        EmployeePosition::create(["name" => "Bar Manager"]);
        EmployeePosition::create(["name" => "Cashier"]);
        EmployeePosition::create(["name" => "Counter Server"]);
        EmployeePosition::create(["name" => "Dishwasher"]);
        EmployeePosition::create(["name" => "Janitor"]);
        EmployeePosition::create(["name" => "Maintenance Staff"]);
        EmployeePosition::create(["name" => "Delivery Driver"]);
        EmployeePosition::create(["name" => "Courier"]);
        EmployeePosition::create(["name" => "Sommelier"]);
        EmployeePosition::create(["name" => "Barista"]);
        EmployeePosition::create(["name" => "Sushi Chef"]);
        EmployeePosition::create(["name" => "Mixologist"]);
        EmployeePosition::create(["name" => "Administrative Assistant"]);
        EmployeePosition::create(["name" => "Receptionist"]);
        EmployeePosition::create(["name" => "Event Coordinator"]);
    }
}
