<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    /**
     * @var string
     */
    protected string $passwordRegex;

    public function __construct()
    {
        $this->passwordRegex = get_register_regex();
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function login($data): JsonResponse
    {
        $user = User::query()->where('email', trim($data['email']))->first();

        if (!$user) {
            return response()->json([
                'message' => [
                    'email' => "Invalid email",
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => [
                    'password' => "Invalid password",
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken($user->email, ['*'], now()->addDay())->plainTextToken;

        return response()->json([
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function registration($data): mixed
    {
        return DB::transaction(function () use ($data) {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => trim($data['email']),
                'password' => $data['password'],
            ]);

            $token = $user->createToken($user->email, ['*'], now()->addDay())->plainTextToken;

            return response()->json([
                'message' => "User successfully registered",
                'token' => $token,
            ]);
        });
    }
}
