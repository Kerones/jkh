<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        return [
            'КодКонтрагента_ID' => $this->КодКонтрагента_ID,
            'Название' => $this->Название,
            'РеестрыКонтрагента' => new RegistryResource($this->registries)
        ];
    }
}
