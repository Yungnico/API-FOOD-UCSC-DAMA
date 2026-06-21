<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemandaHoraria;
use Illuminate\Http\Request;

class DemandaHorariaController extends Controller
{
    public function index()
    {
        return response()->json(DemandaHoraria::with('local')->get());
    }

    public function store(Request $request)
    {
        $demanda = DemandaHoraria::create($request->validate([
            'local_id' => ['required', 'exists:locales,id'],
            'dia_semana' => ['required', 'integer', 'min:0', 'max:6'],
            'hora_inicio' => ['required', 'date_format:H:i:s'],
            'hora_fin' => ['required', 'date_format:H:i:s', 'after:hora_inicio'],
            'nivel_demanda' => ['required', 'string', 'max:255'],
        ]));

        return response()->json($demanda, 201);
    }

    public function show(string $id)
    {
        return response()->json(DemandaHoraria::with('local')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $demanda = DemandaHoraria::findOrFail($id);
        $demanda->update($request->validate([
            'local_id' => ['sometimes', 'exists:locales,id'],
            'dia_semana' => ['sometimes', 'integer', 'min:0', 'max:6'],
            'hora_inicio' => ['sometimes', 'date_format:H:i:s'],
            'hora_fin' => ['sometimes', 'date_format:H:i:s', 'after:hora_inicio'],
            'nivel_demanda' => ['sometimes', 'string', 'max:255'],
        ]));

        return response()->json($demanda);
    }

    public function destroy(string $id)
    {
        DemandaHoraria::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}