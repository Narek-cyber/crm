<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Tariff\TariffResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{'id'},
            'name' => $this->{'name'},
            'tariff' => new TariffResource($this->whenLoaded('tariff')),
            'created_at' => $this->{'created_at'},
            'updated_at' => $this->{'updated_at'},
        ];
    }
}
