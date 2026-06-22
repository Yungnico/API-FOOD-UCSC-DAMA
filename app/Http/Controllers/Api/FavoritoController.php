<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Favorito::with(['usuario', 'producto'])->get());
    }

    public function porUsuario(string $id)
    {
        return response()->json(
            Favorito::with('producto')
                ->where('usuario_id', $id)
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $favorito = Favorito::create($request->validate([
            'usuario_id' => ['required', 'exists:users,id'],
            'producto_id' => ['required', 'exists:productos,id'],
        ]));

        return response()->json($favorito, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Favorito::with(['usuario', 'producto'])->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $favorito = Favorito::findOrFail($id);
        $favorito->update($request->validate([
            'usuario_id' => ['sometimes', 'exists:users,id'],
            'producto_id' => ['sometimes', 'exists:productos,id'],
        ]));

        return response()->json($favorito);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Favorito::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}
