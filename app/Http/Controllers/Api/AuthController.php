<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegiserRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            return $this->authService->login($data);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $error) {
            Log::error($error->getMessage());
            return response()->json([
                'message' => 'Interval server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param RegiserRequest $request
     * @return mixed
     */
    public function registration(RegiserRequest $request): mixed
    {
        try {
            $data = $request->validated();
            return $this->authService->registration($data);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => "User logged out",
        ]);
    }
}
