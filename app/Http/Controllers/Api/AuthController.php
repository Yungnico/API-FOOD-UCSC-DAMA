<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['sometimes', 'nullable', 'string', 'max:255'],
            'apellido_materno' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'objetivos_salud' => ['sometimes', 'nullable', 'string'],
            'calorias_target' => ['sometimes', 'nullable', 'integer', 'min:0'],
        ]);

        $user = User::create([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'] ?? '',
            'apellido_materno' => $data['apellido_materno'] ?? '',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'objetivos_salud' => $data['objetivos_salud'] ?? null,
            'calorias_target' => $data['calorias_target'] ?? 0,
        ]);

        $token = $user->createToken('android')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales invalidas',
            ], 422);
        }

        $token = $user->createToken('android')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Sesion cerrada',
        ]);
    }
}
