<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'room' => $this->room->name,
            'start_date' => Carbon::parse($this->start_date)->translatedFormat('l\, d F Y'),
            'end_date' => Carbon::parse($this->end_date)->translatedFormat('l\, d F Y'),
            'duration' => $this->duration,
            'sub_total' => $this->sub_total,
        ];
    }
}
