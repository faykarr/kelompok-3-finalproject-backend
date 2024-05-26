<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'building_type_id', 'city_id', 'name', 'addrees', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buildingType()
    {
        return $this->belongsTo(BuildingType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function buildingImages()
    {
        return $this->hasMany(BuildingImage::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
