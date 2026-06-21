<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index()
    {
        return response()->json(Local::all());
    }

    public function store(Request $request)
    {
        $local = Local::create($request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'horario' => ['required', 'string', 'max:255'],
            'contacto' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'tiempo_espera_estimado' => ['required', 'integer', 'min:0'],
        ]));

        return response()->json($local, 201);
    }

    public function show($id)
    {
        return response()->json(Local::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $local = Local::findOrFail($id);
        $local->update($request->validate([
            'nombre' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'nullable', 'string'],
            'horario' => ['sometimes', 'string', 'max:255'],
            'contacto' => ['sometimes', 'string', 'max:255'],
            'latitude' => ['sometimes', 'numeric'],
            'longitude' => ['sometimes', 'numeric'],
            'tiempo_espera_estimado' => ['sometimes', 'integer', 'min:0'],
        ]));

        return response()->json($local);
    }

    public function destroy($id)
    {
        Local::destroy($id);

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}