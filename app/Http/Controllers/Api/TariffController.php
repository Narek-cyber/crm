<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tariff\StoreTariffRequest;
use App\Http\Requests\Tariff\UpdateTariffRequest;
use App\Http\Resources\Tariff\TariffResource;
use App\Models\Tariff;
use App\Services\TariffService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TariffController extends Controller
{
    public function __construct(protected TariffService $tariffService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->tariffService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTariffRequest $request): JsonResponse
    {
        return $this->tariffService->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id): TariffResource|JsonResponse
    {
        try {
            return $this->tariffService->show($id);
        } catch (ModelNotFoundException $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . "->" . $e->getMessage());
            return response()->json([
                'message' => 'Tariff not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTariffRequest $request, $id): TariffResource|JsonResponse
    {
        try {
            return $this->tariffService->update($request, $id);
        } catch (ModelNotFoundException $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . "->" . $e->getMessage());
            return response()->json([
                'message' => 'Tariff not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\Response|JsonResponse
    {
        try {
            return $this->tariffService->delete($id);
        } catch (ModelNotFoundException $e) {
            Log::error(__CLASS__ . '::' . __FUNCTION__ . "->" . $e->getMessage());
            return response()->json([
                'message' => 'Post not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
