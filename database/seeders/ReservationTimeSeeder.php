<?php

namespace Database\Seeders;

use App\Models\ReservationTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReservationTime::create(["start_time" => "17:00:00", "end_time" => "18:00:00"]);
        ReservationTime::create(["start_time" => "18:00:00", "end_time" => "19:00:00"]);
        ReservationTime::create(["start_time" => "19:00:00", "end_time" => "20:00:00"]);
        ReservationTime::create(["start_time" => "20:00:00", "end_time" => "21:00:00"]);
        ReservationTime::create(["start_time" => "21:00:00", "end_time" => "22:00:00"]);
        ReservationTime::create(["start_time" => "22:00:00", "end_time" => "23:00:00"]);
    }
}
