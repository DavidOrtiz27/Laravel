<?php

namespace App\Http\Controllers;

use App\Models\Consultorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultorioController extends Controller
{
    // Listar todos los Consultorio
    public function index()
    {
        $Consultorio = Consultorio::all();
        return response()->json($Consultorio);
    }

    // Crear nuevo consultorio
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ciudad_id' => 'required|integer|exists:ciudades,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $consultorio = Consultorio::create($request->all());
        return response()->json($consultorio);
    }

    // Listar consultorio por ID
    public function show(string $id)
    {
        $consultorio = Consultorio::findOrFail($id);
        return response()->json($consultorio);
    }

    // Actualizar consultorio
    public function update(Request $request, string $id)
    {
        $consultorio = Consultorio::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ciudad_id' => 'integer|exists:ciudades,id',
            'nombre' => 'string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $consultorio->update($request->all());
        return response()->json($consultorio);
    }

    // Eliminar consultorio
    public function destroy(string $id)
    {
        $consultorio = Consultorio::findOrFail($id);
        $consultorio->delete();

        return response()->json(['message' => 'Consultorio eliminado']);
    }
}
