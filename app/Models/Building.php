<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'building_type_id',
        'city_id',
        'name',
        'slug',
        'address',
        'description'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($building) {
            $building->slug = Str::slug($building->name);
        });
    }

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

    public function getLowestRoomPrice()
    {
        return $this->rooms->min('price');
    }
}
