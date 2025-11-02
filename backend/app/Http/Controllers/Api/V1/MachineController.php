<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
use App\Repositories\Interfaces\MachineRepositoryInterface;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function __construct(private MachineRepositoryInterface $machineRepository)
    {
    }

    public function index()
    {
        return MachineResource::collection($this->machineRepository->list());
    }
}
