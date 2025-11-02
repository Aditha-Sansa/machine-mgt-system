<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MachineHourLog>
 */
class MachineHourLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'machine_id' => Machine::factory(),
            'hours_added' => $this->faker->randomFloat(2, 0.25, 8),
            'is_reset' => false,
            'created_at' => now()->subDays(rand(1, 30))
        ];
    }

    public function reset(): self
    {
        return $this->state(fn () => [
            'hours_added' => 0,
            'is_reset' => true,
        ]);
    }
}
