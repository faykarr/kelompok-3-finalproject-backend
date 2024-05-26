<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentDetail extends Model
{
    use HasFactory;

    protected $fillable = ['rent_id', 'room_id', 'price', 'start_date', 'end_date', 'duration', 'sub_total'];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
