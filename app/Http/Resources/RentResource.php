<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
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
            'name' => $this->user->name,
            'total' => $this->total,
            'status' => $this->status,
            'paid' => $this->paid,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('l\, d F Y H:i'),
            'detail' => RentDetailResource::collection($this->rentDetails),
        ];
    }
}
