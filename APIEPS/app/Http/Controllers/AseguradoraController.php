<?php

namespace App\Http\Controllers;

use App\Models\Aseguradora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AseguradoraController extends Controller
{
    // Listar todas las aseguradoras
    public function index()
    {
        $aseguradoras = Aseguradora::all();
        return response()->json($aseguradoras);
    }

    // Crear nueva aseguradora
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'nit' => 'required|string|max:50|unique:aseguradoras,nit',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'ciudad' => 'nullable|string|unique:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $aseguradora = Aseguradora::create($request->all());
        return response()->json($aseguradora);
    }

    // Listar aseguradora por ID
    public function show(string $id)
    {
        $aseguradora = Aseguradora::findOrFail($id);
        return response()->json($aseguradora);
    }

    // Actualizar aseguradora
    public function update(Request $request, string $id)
    {
        $aseguradora = Aseguradora::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'nit' => 'string|max:50|unique:aseguradoras,nit,' . $id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'ciudad' => 'nullable|string|unique:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $aseguradora->update($request->all());
        return response()->json($aseguradora);
    }

    // Eliminar aseguradora
    public function destroy(string $id)
    {
        $aseguradora = Aseguradora::findOrFail($id);
        $aseguradora->delete();

        return response()->json(['message' => 'Aseguradora eliminada']);
    }
}
