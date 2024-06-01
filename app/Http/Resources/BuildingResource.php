<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'start_price' => $this->when(!$request->routeIs('building.show'), $this->getLowestRoomPrice()),
            'city' => $this->when($request->routeIs('building.show'), CityResource::make($this->city)),
            'description' => $this->when($request->routeIs('building.show'), $this->description),
            'images' => $this->when($request->routeIs('building.show'), BuildingImageResource::collection($this->buildingImages)),
            'rooms' => $this->when($request->routeIs('building.show'), RoomResource::collection($this->rooms))
        ];
    }
}
