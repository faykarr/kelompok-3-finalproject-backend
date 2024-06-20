<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\ProvinceResource;

class RegionController extends Controller
{
    public function city()
    {
        $cities = City::with('province')->get();

        return response()->json([
            'status' => 'success',
            'data' => CityResource::collection($cities)
        ]);
    }

    public function province()
    {
        $provinces = Province::all();

        return response()->json([
            'status' => 'success',
            'data' => ProvinceResource::collection($provinces)
        ]);
    }
}
