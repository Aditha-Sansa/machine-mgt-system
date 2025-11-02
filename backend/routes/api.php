<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MachineController;


Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/machines', [MachineController::class, 'index']);
        Route::post('/machines', [MachineController::class, 'store']);
        Route::get('/machines/{id}', [MachineController::class, 'show']);


        Route::post('/machines/{id}/add-hours', [MachineController::class, 'addHours']);
        Route::post('/machines/{id}/reset', [MachineController::class, 'resetHours']);
        Route::get('/machines/{id}/hours', [MachineController::class, 'hours']);
    });

});