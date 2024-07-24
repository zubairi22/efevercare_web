<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemperatureReadingSeeder extends Seeder
{
    public function run()
    {
        $userId = 3;
        $numberOfReadings = 50;
        $startDate = Carbon::now()->subDays(2);
        $endDate = Carbon::now();

        for ($i = 0; $i < $numberOfReadings; $i++) {
            $readingTime = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
            $temperature = rand(360, 380) / 10;

            DB::table('temperature_readings')->insert([
                'user_id' => $userId,
                'temperature' => $temperature,
                'reading_time' => $readingTime,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
