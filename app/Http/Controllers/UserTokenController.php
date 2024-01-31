<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:16'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'El email no existe o no coincide con nuestros datos.'
            ]);
        }

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        $token = $user->createToken($request->name);

        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }
}
