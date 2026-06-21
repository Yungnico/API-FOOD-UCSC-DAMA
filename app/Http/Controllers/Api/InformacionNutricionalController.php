<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InformacionNutricional;
use Illuminate\Http\Request;

class InformacionNutricionalController extends Controller
{
    public function index()
    {
        return response()->json(InformacionNutricional::with('producto')->get());
    }

    public function store(Request $request)
    {
        $informacion = InformacionNutricional::create($request->validate([
            'producto_id' => ['required', 'exists:productos,id', 'unique:informacion_nutricional,producto_id'],
            'calorias' => ['required', 'integer', 'min:0'],
            'proteina' => ['required', 'numeric', 'min:0'],
            'carbohidratos' => ['required', 'numeric', 'min:0'],
            'grasas' => ['required', 'numeric', 'min:0'],
            'sodio' => ['required', 'numeric', 'min:0'],
            'puntaje' => ['required', 'numeric', 'min:0'],
        ]));

        return response()->json($informacion, 201);
    }

    public function show(string $id)
    {
        return response()->json(InformacionNutricional::with('producto')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $informacion = InformacionNutricional::findOrFail($id);
        $informacion->update($request->validate([
            'producto_id' => ['sometimes', 'exists:productos,id', 'unique:informacion_nutricional,producto_id,' . $informacion->id],
            'calorias' => ['sometimes', 'integer', 'min:0'],
            'proteina' => ['sometimes', 'numeric', 'min:0'],
            'carbohidratos' => ['sometimes', 'numeric', 'min:0'],
            'grasas' => ['sometimes', 'numeric', 'min:0'],
            'sodio' => ['sometimes', 'numeric', 'min:0'],
            'puntaje' => ['sometimes', 'numeric', 'min:0'],
        ]));

        return response()->json($informacion);
    }

    public function destroy(string $id)
    {
        InformacionNutricional::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}