<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender === 'L' ? 'Laki-laki' : 'Perempuan',
            'photo' => $this->photo,
            'role' => $this->role
        ];
    }
}
