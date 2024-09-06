<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TokenController extends Controller
{
    public function createToken(Request $request)
    {
        $user = User::find($request->user_id); // Fetch the user by ID
        if ($user) {
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}


