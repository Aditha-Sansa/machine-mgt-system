<?php

namespace Database\Factories;

use App\Models\Machine;
use App\Models\MachineHourLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'purchase_date' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'purchase_price' => fake()->randomFloat(2, 1000, 100000),
            'category' => fake()->randomElement(['Large', 'Medium', 'Small']),
            'brand' => fake()->randomElement(['BMW', 'Suzuki', 'CAT']),
        ];
    }

    public function withLogs()
    {
        return $this->afterCreating(function ($machine) {
            MachineHourLog::factory()->count(rand(2, 5))->create([
                'machine_id' => $machine->id
            ]);

            if (rand(0, 1)) {
                MachineHourLog::factory()->reset()->create([
                    'machine_id' => $machine->id
                ]);
            }
        });
    }
}
