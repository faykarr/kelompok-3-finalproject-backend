<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'name' => $this->name,
            'capacity' => $this->capacity,
            'price' => $this->price,
            'description' => $this->description,
            'is_available' => $this->is_available ? 'Available' : 'Not Available',
            'images' => RoomImageResource::collection($this->roomImages)
        ];
    }
}
