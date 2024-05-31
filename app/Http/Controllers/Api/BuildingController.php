<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\User;
use App\Models\Building;
use App\Models\Province;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BuildingImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\BuildingResource;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buildings = Building::whereHas('city', function($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        })->orWhereHas('city.province', function($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        })->orWhere('name', 'like', '%'.$request->search.'%')->get();

        if ($buildings->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No building found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => BuildingResource::collection($buildings)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Building::class)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to create a building'
            ], 403);
        }

        if ($request->user()->building()->count() >= 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have reached the maximum number of buildings'
            ], 403);
        }

        $building = $request->user()->building()->create([
            'name' => $request->name,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'building_type_id' => $request->building_type_id,
            'description' => $request->description
        ]);

        return new BuildingResource($building);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        return new BuildingResource($building);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $building = $request->user()->building()->first();

        if (Gate::denies('update', $building)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this building'
            ], 403);
        }

        return new BuildingResource($building);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        if ($request->user()->cannot('update', $building)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this building'
            ], 403);
        }

        $building->update([
            'name' => $request->name,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'building_type_id' => $request->building_type_id,
            'description' => $request->description
        ]);

        $building->slug = Str::slug($request->name);

        $building->update();

        return new BuildingResource($building);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getBuildingByCity(City $city)
    {
        // $buildings = Building::where('city_id', $city->id)->get();
        $buildings = $city->buildings;

        if ($buildings->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No building found in this city'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => BuildingResource::collection($buildings)
        ]);
    }

    public function getBuildingByProvince(Province $province)
    {
        $buildings = Building::whereHas('city', function($query) use ($province) {
            $query->where('province_id', $province->id);
        })->get();

        if ($buildings->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No building found in this province'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => BuildingResource::collection($buildings)
        ]);
    }
}
