<?php

namespace Database\Seeders;

use App\Models\FieldSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldSchedule::create([
            'start_time' => '06:00:00',
            'end_time' => '07:00:00',
            'is_active' => true
        ]);
        FieldSchedule::create([
            'start_time' => '07:00:00',
            'end_time' => '08:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '11:00:00',
            'end_time' => '12:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '13:00:00',
            'end_time' => '14:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '14:00:00',
            'end_time' => '15:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '15:00:00',
            'end_time' => '16:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '16:00:00',
            'end_time' => '17:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '17:00:00',
            'end_time' => '18:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '19:00:00',
            'end_time' => '20:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '20:00:00',
            'end_time' => '21:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '21:00:00',
            'end_time' => '22:00:00',
            'is_active' => true
        ]);

        FieldSchedule::create([
            'start_time' => '22:00:00',
            'end_time' => '23:00:00',
            'is_active' => true
        ]);
    }
}
