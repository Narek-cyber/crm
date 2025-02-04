<?php

namespace App\Http\Resources\Tariff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
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
            'max_users' => $this->{'max_users'},
            'price' => $this->{'price'},
            'created_at' => $this->{'created_at'},
            'updated_at' => $this->{'updated_at'},
        ];
    }
}
