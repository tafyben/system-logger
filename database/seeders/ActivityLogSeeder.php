<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user (or create one if none exists)
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        // Temporarily authenticate as the user
        Auth::login($user);

        // Generate some fake activity logs
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['ip' => '127.0.0.1', 'action' => 'login'])
            ->log('User logged in');

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['section' => 'Profile', 'change' => 'Updated name'])
            ->log('User updated profile');

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['section' => 'Posts', 'post_id' => 15])
            ->log('User created a post');

        $this->command->info('Sample activity logs have been created.');
    }
}
