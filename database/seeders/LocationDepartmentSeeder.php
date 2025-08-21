<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Chitepo Campus' => ['High School', 'Business School', 'Study Centre', 'Computer and Secretarial'],
            'Bulawayo Campus' => ['Engineering', 'Business Studies', 'Hospitality'],
            'Chitungwiza Campus' => ['ICT', 'Nursing School'],
            'Highfield Campus' => ['Primary School', 'Admin Department'],
        ];

        foreach ($locations as $locationName => $departments) {
            $location = Location::create([
                'name' => $locationName,
                'description' => $locationName . ' Address', //placeholder
            ]);
            foreach ($departments as $deptName) {
                Department::create([
                    'name' => $deptName,
                    'location_id' => $location->id,
                ]);
            }
        }
    }
}
