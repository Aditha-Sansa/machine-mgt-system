<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (! Auth::attempt($data)) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials']);
        }

        $user = $this->userRepository->findByEmail($data['email']);
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);

    }


    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
