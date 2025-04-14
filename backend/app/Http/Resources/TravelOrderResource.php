<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'destino' => $this->destino->toArray(),
            'user' => new UsersResource($this->whenLoaded('user')),
            'data_ida' => $this->data_ida,
            'data_volta' => $this->data_volta
        ];
    }
}
