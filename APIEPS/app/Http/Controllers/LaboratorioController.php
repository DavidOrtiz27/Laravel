<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratorioController extends Controller
{
    // Listar todos los Laboratorio
    public function index()
    {
        $Laboratorio = Laboratorio::all();
        return response()->json($Laboratorio);
    }

    // Crear nuevo laboratorio
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $laboratorio = Laboratorio::create($request->all());
        return response()->json($laboratorio);
    }

    // Listar laboratorio por ID
    public function show(string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);
        return response()->json($laboratorio);
    }

    // Actualizar laboratorio
    public function update(Request $request, string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $laboratorio->update($request->all());
        return response()->json($laboratorio);
    }

    // Eliminar laboratorio
    public function destroy(string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);
        $laboratorio->delete();

        return response()->json(['message' => 'Laboratorio eliminado']);
    }
}
