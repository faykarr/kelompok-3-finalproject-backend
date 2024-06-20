<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['building_id', 'facility_id', 'name', 'capacity', 'price', 'description', 'is_available'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function roomFacility()
    {
        return $this->hasOne(Facility::class);
    }

    public function roomImages()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function rentDetails()
    {
        return $this->hasMany(RentDetail::class);
    }
}
