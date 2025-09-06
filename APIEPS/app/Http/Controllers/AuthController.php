<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en el sistema.
     *
     * @group Auth
     * @bodyParam name string required Nombre del usuario. Example: John Doe
     * @bodyParam email string required Correo electrónico del usuario. Example: john@example.com
     * @bodyParam password string required Contraseña del usuario. Example: password123
     *
     * @response 200 scenario="Success" {
     *   "message": "Usuario creado satisfactoriamente",
     *   "user": {
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "role": "user"
     *   },
     *   "role": "user"
     * }
     *
     * @unauthenticated
     */
    public function registrar(Request $request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>'user'
        ]);
        return response()->json([
            'message'=>'Usuario creado satisfactoriamente',
            'user'=>$user,
            'role'=>$user->role
        ]);
    }

    /**
     * Registra un nuevo administrador en el sistema.
     *
     * @group Auth
     * @bodyParam name string required Nombre del administrador. Example: Admin User
     * @bodyParam email string required Correo electrónico del administrador. Example: admin@example.com
     * @bodyParam password string required Contraseña del administrador. Example: admin123
     *
     * @response 200 scenario="Success" {
     *   "message": "Admin creado satisfactoriamente",
     *   "user": {
     *     "name": "Admin User",
     *     "email": "admin@example.com",
     *     "role": "admin"
     *   },
     *   "role": "admin"
     * }
     */
    public function registrarAdmin(Request $request)
    {
        $admin = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>'admin'
        ]);
        return response()->json([
            'message'=>'Admin creado satisfactoriamente',
            'user'=>$admin,
            'role'=>$admin->role
        ]);
    }

    /**
     * Inicia sesión de usuario y genera token de acceso.
     *
     * @group Auth
     * @bodyParam email string required Correo electrónico del usuario. Example: user@example.com
     * @bodyParam password string required Contraseña del usuario. Example: password123
     *
     * @response 200 scenario="Success" {
     *   "message": "Login exitoso",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "user@example.com",
     *     "role": "user"
     *   },
     *   "token": "1|example-token-string"
     * }
     * @response 401 scenario="Invalid credentials" {
     *   "message": "Credenciales incorrectas"
     * }
     *
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message'=>'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message'=>'Login exitoso',
            'user'=>[
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'role'=>$user->role, // 👈 aquí va el rol
            ],
            'token'=>$token
        ]);
    }

    /**
     * Cierra la sesión del usuario actual eliminando el token de acceso.
     *
     * @group Auth
     * @authenticated
     *
     * @response 200 scenario="Success" {
     *   "message": "Sesión cerrada"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Sesión cerrada']);
    }
}
