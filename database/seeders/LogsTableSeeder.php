<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\LogType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }

        // Create some log types if not exist
        if (LogType::count() === 0) {
            $types = ['System Update', 'Network Change', 'User Action', 'Maintenance', 'Error'];
            foreach ($types as $type) {
                LogType::create(['name' => $type]);
            }
        }

        // Now seed logs
        $users = User::all();
        $types = LogType::all();

        for ($i = 1; $i <= 20; $i++) {
            Log::create([
                'event_time'      => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d H:i:s'),
                'log_type_id'         => $types->random()->id,
                'title'           => fake()->sentence(4),
                'description'           => fake()->sentence(4),
                'affected_system' => fake()->randomElement(['Database Server', 'Web Server', 'Email System', 'Router', 'Workstation']),
                'user_id'         => $users->random()->id,
            ]);
        }
    }
}
