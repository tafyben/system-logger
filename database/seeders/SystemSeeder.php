<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\System::insert([
            ['name' => 'Website'],
            ['name' => 'Database Server'],
            ['name' => 'Router'],
            ['name' => 'PC Workstation'],
        ]);
    }
}
