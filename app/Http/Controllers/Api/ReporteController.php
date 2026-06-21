<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Reporte::with(['usuario', 'local'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json(Reporte::create($request->validate([
            'usuario_id' => ['required', 'exists:users,id'],
            'local_id' => ['required', 'exists:locales,id'],
            'descripcion' => ['required', 'string'],
            'estado' => ['sometimes', 'string', 'max:255'],
        ])), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Reporte::with(['usuario', 'local'])->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reporte = Reporte::findOrFail($id);
        $reporte->update($request->validate([
            'usuario_id' => ['sometimes', 'exists:users,id'],
            'local_id' => ['sometimes', 'exists:locales,id'],
            'descripcion' => ['sometimes', 'string'],
            'estado' => ['sometimes', 'string', 'max:255'],
        ]));

        return response()->json($reporte);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Reporte::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}
