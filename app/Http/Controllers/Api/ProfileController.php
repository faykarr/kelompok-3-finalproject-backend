<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if (!empty($user->photo) && Storage::disk('local')->exists($user->photo)) {
                Storage::disk('local')->delete($user->photo);
            }

            $validated['photo'] = Storage::disk('local')->put('profile', $request->file('photo'));
        }

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
