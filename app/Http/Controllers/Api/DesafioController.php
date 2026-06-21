<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Desafio;
use Illuminate\Http\Request;

class DesafioController extends Controller
{
    public function index()
    {
        return response()->json(Desafio::with('usuarios')->get());
    }

    public function store(Request $request)
    {
        $desafio = Desafio::create($request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'recompensa_puntos' => ['required', 'integer', 'min:0'],
            'reglas_json' => ['required', 'array'],
        ]));

        return response()->json($desafio, 201);
    }

    public function show(string $id)
    {
        return response()->json(Desafio::with('usuarios')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $desafio = Desafio::findOrFail($id);
        $desafio->update($request->validate([
            'titulo' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'string'],
            'recompensa_puntos' => ['sometimes', 'integer', 'min:0'],
            'reglas_json' => ['sometimes', 'array'],
        ]));

        return response()->json($desafio);
    }

    public function destroy(string $id)
    {
        Desafio::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}