<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaComida;
use Illuminate\Http\Request;

class CategoriaComidaController extends Controller
{
    public function index()
    {
        return response()->json(CategoriaComida::with('productos')->get());
    }

    public function store(Request $request)
    {
        $categoria = CategoriaComida::create($request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias_comida,nombre'],
        ]));

        return response()->json($categoria, 201);
    }

    public function show(string $id)
    {
        return response()->json(CategoriaComida::with('productos')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $categoria = CategoriaComida::findOrFail($id);
        $categoria->update($request->validate([
            'nombre' => ['sometimes', 'string', 'max:255', 'unique:categorias_comida,nombre,' . $categoria->id],
        ]));

        return response()->json($categoria);
    }

    public function destroy(string $id)
    {
        CategoriaComida::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}