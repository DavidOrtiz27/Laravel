<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicamentoController extends Controller
{
    // Listar todos los Medicamento
    public function index()
    {
        $Medicamento = Medicamento::all();
        return response()->json($Medicamento);
    }

    // Crear nuevo medicamento
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'dosis' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medicamento = Medicamento::create($request->all());
        return response()->json($medicamento);
    }

    // Listar medicamento por ID
    public function show(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        return response()->json($medicamento);
    }

    // Actualizar medicamento
    public function update(Request $request, string $id)
    {
        $medicamento = Medicamento::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'dosis' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medicamento->update($request->all());
        return response()->json($medicamento);
    }

    // Eliminar medicamento
    public function destroy(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->delete();

        return response()->json(['message' => 'Medicamento eliminado']);
    }
}
