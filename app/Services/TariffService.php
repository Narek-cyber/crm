<?php

namespace App\Services;

use App\Http\Requests\Tariff\StoreTariffRequest;
use App\Http\Resources\Tariff\TariffResource;
use App\Models\Tariff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class TariffService
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TariffResource::collection(Tariff::all());
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function store($data): JsonResponse
    {
        $tariff = Tariff::query()->create($data);
        return response()->json([
            'tariff' => new TariffResource($tariff)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return TariffResource
     */
    public function show($id): TariffResource
    {
        $tariff = Tariff::query()->findOrFail($id);
        return new TariffResource($tariff);
    }

    /**
     * @param $request
     * @param $id
     * @return TariffResource
     */
    public function update($request, $id): TariffResource
    {
        $tariff = Tariff::query()->findOrFail($id);
        $tariff->update($request->validated());
        return new TariffResource($tariff);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id): \Illuminate\Http\Response
    {
        Tariff::query()->findOrFail($id)->delete();
        return response()->noContent();
    }
}
