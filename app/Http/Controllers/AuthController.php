<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // If we reach here, validation has already passed!
        // Laravel automatically validates using our RegisterUserRequest

        try {
            $shouldValidate = ['phone', 'role', 'first_name', 'last_name',  'password'];
            foreach ($shouldValidate as $value) {
                $exist = request()->input($value);
                if ($exist == null) {
                    return response()->json([
                        "message" => "incomplete data",
                        "field" => $value
                    ], 400);
                }
            }
            // Handle file uploads
            $profileImagePath = null;
            $idImagePath = null;

            if ($request->hasFile('profile_image')) {
                $profileImagePath = $request->file('profile_image')->store('profiles', 'public');
            }

            if ($request->hasFile('id_image')) {
                $idImagePath = $request->file('id_image')->store('ids', 'public');
            }

            // Create user
            $user = User::create([
                'phone' => $request->phone,
                'role' => $request->role,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'profile_image' => $profileImagePath,
                'id_image' => $idImagePath,
                'password' => Hash::make($request->password),
                // is_approved defaults to false automatically
            ]);

            return response()->json([
                'message' => 'Registration successful. Waiting for admin approval.',
                'user' => [
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'full_name' => $user->full_name,
                    'role' => $user->role,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Basic validation for login

        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        try {
            // Find user by phone
            $user = User::where('phone', $request->phone)->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Check if user is approved
            if (!$user->is_approved) {
                return response()->json([
                    'message' => 'Account pending admin approval. Please wait for approval.'
                ], 403);
            }

            // Create API token
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'full_name' => $user->full_name,
                    'role' => $user->role,
                ]
            ]);
        } catch (\Exception $exc) {
            return response()->json([
                "message" => "failed!",
                "errors" => $exc->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        // Delete the current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
