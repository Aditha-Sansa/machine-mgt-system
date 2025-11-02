<?php

namespace App\Repositories\Eloquent;

use App\Models\Machine;
use App\Models\MachineHourLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
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

    //Machine Hour Logs

    public function addHours(int $machineId, $hours): MachineHourLog
    {
        $machine = $this->find($machineId);

        $isSameHourValueExist = $machine->hourLogs()
            ->where('is_reset', false)
            ->where('hours_added', $hours)->count();

        if ($isSameHourValueExist > 0) {
            throw ValidationException::withMessages(['hours' => 'Cannot add the same amount of hours twice']);
        }

        $machine->hourLogs()->create([
            'hours_added' => $hours,
            'is_reset' => false,
        ]);

        return $this->find($machineId)->hourLogs()->latest()->first();
    }

}