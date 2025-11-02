<?php

namespace Tests\Feature\Api;

use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MachineTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_the_user_can_list_machines(): void
    {
        Machine::factory()->count(3)->create();

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
}
