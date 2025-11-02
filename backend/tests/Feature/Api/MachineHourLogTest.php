<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Machine;
use App\Models\MachineHourLog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use App\Repositories\Eloquent\MachineRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MachineHourLogTest extends TestCase
{
    use RefreshDatabase;

    protected MachineHourLog $machineHourLog;

    protected function setUp(): void
    {
        parent::setUp();

        $this->machineHourLog = MachineHourLog::factory()->create([
            'hours_added' => 1.5,
            'is_reset' => false
        ]);
    }

    public function test_it_cannot_duplicate_hour_values(): void
    {

        $machineId = $this->machineHourLog->machine_id;

        $response = $this->actingAsSanctumUser()->postJson('/api/v1/machines/'.$machineId.'/add-hours', [
            "hours" => 1.5
        ]);

        $response->assertStatus(422)
            ->assertOnlyJsonValidationErrors(['hours'])
            ->assertInvalid([
                'hours' => 'Cannot add the same amount of hours twice',
            ]);
    }

    public function test_it_can_add_unique_hour_values()
    {

        $machineId = $this->machineHourLog->machine_id;

        $response = $this->actingAsSanctumUser()->postJson('/api/v1/machines/'.$machineId.'/add-hours', [
            "hours" => 1
        ]);

        $response->assertStatus(201)->assertJson([
            "message" => "Successfully Updated Hours",
            "data" => [
                "machine_id" => $machineId,
                "hours_added" => 1,
                "is_reset" => 0
            ]
        ]);
    }

    public function test_it_can_reset_hours()
    {
        $machineId = $this->machineHourLog->machine_id;

        $response = $this->actingAsSanctumUser()->postJson('/api/v1/machines/'.$machineId.'/reset');

        $response->assertStatus(201)->assertJson([
            "message" => "Successfully Reset the Hours",
            "data" => [
                "machine_id" => $machineId,
                "hours_added" => 0,
                "is_reset" => 1
            ]
        ]);
    }

    public function test_it_cannot_reset_if_the_total_hours_are_zero()
    {
        $machineId = $this->machineHourLog->machine_id;
        $machine = Machine::find($machineId);

        $machine->hourLogs()->create([
            'hours_added' => 0,
            'is_reset' => true
        ]);

        $response = $this->actingAsSanctumUser()->postJson('/api/v1/machines/'.$machineId.'/reset');
        $response->assertStatus(422)
            ->assertOnlyJsonValidationErrors(['reset'])
            ->assertInvalid([
                'reset' => 'This machine hours are already at zero.',
            ]);

    }
}
