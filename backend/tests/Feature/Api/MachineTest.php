<?php

namespace Tests\Feature\Api;

use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MachineTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_can_list_machines(): void
    {
        Machine::factory()->withLogs()->count(3)->create();

        $response = $this->actingAsSanctumUser()->getJson('api/v1/machines');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'purchase_date', 'purchase_price', 'reset_count']
                ]
            ]);
    }

    public function test_the_user_can_create_a_machine()
    {
        $machineRecordToCreate = [
            'name' => "Sprayer Machine",
            'purchase_date' => now()->toDateString(),
            'purchase_price' => 43000.00,
            'category' => 'Large',
            'brand' => 'CAT'
        ];

        $machineRecordToExpectFromServer = [
            'id' => 1,
            'name' => $machineRecordToCreate['name'],
            'purchase_date' => $machineRecordToCreate['purchase_date'],
            'purchase_price' => $machineRecordToCreate['purchase_price'],
            'reset_count' => 0,
            'total_hours' => 0
        ];

        $response = $this->actingAsSanctumUser()->postJson('api/v1/machines', $machineRecordToCreate);

        $response
            ->assertStatus(201)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'purchase_date',
                    'purchase_price',
                    'reset_count',
                    'total_hours'
                ]
            ])
            ->assertExactJson(['data' => $machineRecordToExpectFromServer]);
    }
}
