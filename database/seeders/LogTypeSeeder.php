<?php

namespace Database\Seeders;

use App\Models\LogType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = [
            ['name' => 'PC Change', 'description' => 'Hardware or software changes to PCs'],
            ['name' => 'SSMS Update', 'description' => 'Update to the internal SSMS'],
            ['name' => 'Website Update', 'description' => 'Changes to internal or public websites'],
            ['name' => 'Maintenance', 'description' => 'Network or infrastructure maintenance'],
            ['name' => 'Database Update', 'description' => 'SSMS or other DB changes'],
        ];

        foreach ($types as $type) {
            LogType::create($type);
        }
    }
}
