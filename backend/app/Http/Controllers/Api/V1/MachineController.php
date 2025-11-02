<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\Machine\AddHoursRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
use App\Http\Requests\V1\Machine\StoreMachineRequest;
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

    public function addHours(AddHoursRequest $addHoursRequest, int $id): JsonResponse
    {
        $createdHourLog = $this->machineRepository->addHours($id, $addHoursRequest->validated()['hours']);

        return response()->json(['message' => 'Successfully Updated Hours', "data" => $createdHourLog], 201);
    }

    public function resetHours(int $id)
    {
        $resetHourLog = $this->machineRepository->resetHours($id);

        return response()->json(['message' => 'Successfully Reset the Hours', "data" => $resetHourLog], 201);
    }

}
