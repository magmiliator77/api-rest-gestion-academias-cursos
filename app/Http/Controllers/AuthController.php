<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/register: crea el usuario y le devuelve su token
    public function register(Request $request)
    {
        // Si algo no es válido, Laravel devuelve solo un JSON con los errores y el código 422
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token_de_acceso')->plainTextToken;

        // 201 Created porque se acaba de crear un usuario nuevo
        return response()->json([
            'message' => 'Usuario registrado',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // POST /api/login: comprueba el email y la contraseña y devuelve un token nuevo
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // 401 Unauthorized si el usuario no existe o la contraseña no coincide
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('token_de_acceso')->plainTextToken;

        return response()->json([
            'message' => 'Sesión iniciada',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // POST /api/logout: borra el token con el que se ha hecho la petición
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada']);
    }
}
