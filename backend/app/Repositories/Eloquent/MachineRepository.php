<?php

namespace App\Repositories\Eloquent;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\MachineRepositoryInterface;

class MachineRepository implements MachineRepositoryInterface
{
    public function list(): LengthAwarePaginator|Collection
    {
        return Machine::query()->withCount([
            'hourLogs as reset_count' => fn ($q) => $q->where('is_reset', true)
        ])->latest()->get();
    }

    public function find(int $id): Machine
    {
        return Machine::with('hourLogs')->findOrFail($id);
    }

    public function create(array $data): Machine
    {
        return Machine::create($data);
    }

    public function update(int $id, array $data): Machine
    {
        $machine = $this->find($id);
        $machine->update($data);

        return $machine->refresh();
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

}