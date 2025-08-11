<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\LogType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Log::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'log_type_id' => LogType::inRandomOrder()->first()->id ?? 1,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'affected_system' => $this->faker->word . '-' . $this->faker->randomNumber(2),
            'changes' => json_encode(['old' => 'v1', 'new' => 'v2']),
            'event_time' => now(),
        ];
    }
}
