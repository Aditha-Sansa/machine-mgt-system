<?php

namespace App\Http\Controllers\Api\V1;

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
}
