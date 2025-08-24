<?php

namespace App\Http\Controllers;


use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    // Listar todas las Especialidad
    public function index()
    {
        $Especialidad = Especialidad::all();
        return response()->json($Especialidad);
    }

    // Crear nueva especialidad
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $especialidad = Especialidad::create($request->all());
        return response()->json($especialidad);
    }

    // Listar especialidad por ID
    public function show(string $id)
    {
        $especialidad = Especialidad::findOrFail($id);
        return response()->json($especialidad);
    }

    // Actualizar especialidad
    public function update(Request $request, string $id)
    {
        $especialidad = Especialidad::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $especialidad->update($request->all());
        return response()->json($especialidad);
    }

    // Eliminar especialidad
    public function destroy(string $id)
    {
        $especialidad = Especialidad::find($id);

        if ($especialidad->citas()->count() > 0) {
            return response()->json([
                'error' => 'No se puede eliminar, hay citas asociadas.'
            ], 400);
        }

        $especialidad->delete();

        return response()->json(['message' => 'Especialidad eliminada']);
    }
}
