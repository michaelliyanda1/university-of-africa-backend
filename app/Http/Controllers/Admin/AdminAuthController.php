<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!in_array($user->role, ['admin', 'staff'])) {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $token = $user->createToken('admin_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function createAdmin(Request $request)
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@universityofafrica.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        return response()->json(['message' => 'Admin user created', 'user' => $user]);
    }
}
