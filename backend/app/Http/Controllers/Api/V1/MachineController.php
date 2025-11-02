<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
use App\Http\Resources\MachineHourLogResource;
use App\Http\Requests\V1\Machine\AddHoursRequest;
use App\Http\Requests\V1\Machine\StoreMachineRequest;
use App\Http\Requests\V1\Machine\UpdateMachineRequest;
use App\Repositories\Interfaces\MachineRepositoryInterface;

class MachineController extends Controller
{
    public function __construct(private MachineRepositoryInterface $machineRepository)
    {
    }

    public function index()
    {
        return MachineResource::collection($this->machineRepository->list());
    }

    public function store(StoreMachineRequest $storeMachineRequest): JsonResponse
    {
        $createdMachineRecord = $this->machineRepository->create($storeMachineRequest->validated());

        return (new MachineResource($createdMachineRecord))->response()->setStatusCode(201);
    }

    public function show(int $id): MachineResource
    {
        return new MachineResource($this->machineRepository->find($id));
    }

    public function update(UpdateMachineRequest $updateMachineRequest, $id)
    {
        $updatedMachineRecord = $this->machineRepository->update($id, $updateMachineRequest->validated());

        return (new MachineResource($updatedMachineRecord))->response()->setStatusCode(200);
    }

    public function destroy($id): Response
    {
        $this->machineRepository->delete($id);

        return response()->noContent();
    }

    public function addHours(AddHoursRequest $addHoursRequest, int $id): JsonResponse
    {
        $createdHourLog = $this->machineRepository->addHours($id, $addHoursRequest->validated()['hours']);

        return response()->json(['message' => 'Successfully Updated Hours', "data" => $createdHourLog], 201);
    }

    public function resetHours(int $id): JsonResponse
    {
        $resetHourLog = $this->machineRepository->resetHours($id);

        return response()->json(['message' => 'Successfully Reset the Hours', "data" => $resetHourLog], 201);
    }

    public function hours(int $id)
    {
        $hourLogs = $this->machineRepository->hourHistory($id);

        return MachineHourLogResource::collection($hourLogs);
    }

}
