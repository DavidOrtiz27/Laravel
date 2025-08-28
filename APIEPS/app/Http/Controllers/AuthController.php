<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
           'message'=>'Usuario creado satisfactoriamente',
           'user'=>$user
        ]);
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message'=>'credenciales incorrectas']);
        }

        $token = $user->createToken('token')->plainTextToken;


        return response()->json([
            'user'=>$user,
            'token'=>$token
        ]);
    }

    public function logout(Request $request)
    {
       $request->user()->currentAccessToken()->delete();
       return response()->json(['message'=>'session cerrada']);
    }
}
