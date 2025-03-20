<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => $this->faker->date(),
            'from' => $this->faker->time(),
            'to' => $this->faker->time(),
            'is_closed' => $this->faker->boolean(),
            'user_id' => 1,
        ];
    }
}
