<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface
{
    public function list(): LengthAwarePaginator|Collection
    {
        return User::query()->latest()->get();
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}