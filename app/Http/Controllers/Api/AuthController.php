<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:6|max:255',
            'role' => 'required|in:admin,owner,user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'nama' => $request['nama'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User created successfully!',
            ],
            'data' => [
                'user' => $user,
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60, // Token expires in seconds
                ],
            ],
        ]);
    }

    public function login(Request $request)
    {
        // Validate the login request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user and generate a token
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json(['errors' => ['message' => 'Invalid credentials']], 401);
        }

        // Return the response as JSON
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Login successful',
            ],
            'data' => [
                'user' => auth()->user(),
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60,
                ],
            ],
        ]);
    }

    public function logout()
    {
        // Get the token
        $token = JWTAuth::getToken();

        // Invalidate the token
        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Successfully logged out',
                ],
                'data' => [],
            ]);
        }

        return response()->json(['errors' => ['message' => 'Failed to log out']], 500);
    }
}
