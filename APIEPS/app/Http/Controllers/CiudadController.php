<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CiudadController extends Controller
{
    // Listar todas las Ciudad
    public function index()
    {
        $Ciudad = Ciudad::all();
        return response()->json($Ciudad);
    }

    // Crear nueva ciudad
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $ciudad = Ciudad::create($request->all());
        return response()->json($ciudad);
    }

    // Listar ciudad por ID
    public function show(string $id)
    {
        $ciudad = Ciudad::findOrFail($id);
        return response()->json($ciudad);
    }

    // Actualizar ciudad
    public function update(Request $request, string $id)
    {
        $ciudad = Ciudad::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $ciudad->update($request->all());
        return response()->json($ciudad);
    }

    // Eliminar ciudad
    public function destroy(string $id)
    {
        $ciudad = Ciudad::findOrFail($id);
        $ciudad->delete();

        return response()->json(['message' => 'Ciudad eliminada']);
    }
}
