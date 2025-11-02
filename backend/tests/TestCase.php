<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function actingAsSanctumUser(?User $user = null): self
    {
        $user ??= User::factory()->create();
        $token = $user->createToken('api')->plainTextToken;
        return $this->withHeader('Authorization', 'Bearer '.$token);
    }
}
