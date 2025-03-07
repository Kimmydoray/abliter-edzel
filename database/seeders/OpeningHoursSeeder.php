<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('opening_hours')->insert([
            [
                'day' => 'Monday',
                'open_time' => '08:00:00',
                'close_time' => '16:00:00',
                'lunch_start' => '12:00:00',
                'lunch_end' => '12:45:00',
                'is_open_every_other_week' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'day' => 'Wednesday',
                'open_time' => '08:00:00',
                'close_time' => '16:00:00',
                'lunch_start' => '12:00:00',
                'lunch_end' => '12:45:00',
                'is_open_every_other_week' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'day' => 'Friday',
                'open_time' => '08:00:00',
                'close_time' => '16:00:00',
                'lunch_start' => '12:00:00',
                'lunch_end' => '12:45:00',
                'is_open_every_other_week' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'day' => 'Saturday',
                'open_time' => '08:00:00',
                'close_time' => '16:00:00',
                'lunch_start' => null,  // No lunch break specified for Saturday
                'lunch_end' => null,
                'is_open_every_other_week' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
