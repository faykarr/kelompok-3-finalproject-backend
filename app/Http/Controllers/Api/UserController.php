<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function me(Request $request) 
    {
        // Use $request->user() to get authenticated user data
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Unauthenticated.',
                ],
                'data' => [],
            ], 401);
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User fetched successfully!',
            ],
            'data' => [
                'user' => $user,
            ],
        ]);
    }

    public function users()
    {
        return response()->json([
            'status' => 'anda adalah user'
        ]);
    }

    public function admin()
    {
        return response()->json([
            'status' => 'anda adalah admin'
        ]);
    }

    public function owner()
    {
        return response()->json([
            'status' => 'anda adalah owner'
        ]);
    }
}