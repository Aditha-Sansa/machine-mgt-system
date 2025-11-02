<?php

namespace App\Repositories\Interfaces;

use App\Models\Machine;
use App\Models\MachineHourLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MachineRepositoryInterface
{
    public function list(): LengthAwarePaginator|Collection;
    public function find(int $id): Machine;
    public function create(array $data): Machine;
    public function update(int $id, array $data): Machine;
    public function delete(int $id): void;

    public function addHours(int $machineId, $hours): MachineHourLog;
    public function resetHours(int $machineId): MachineHourLog;
    public function hourHistory(int $machineId): Collection; 
}