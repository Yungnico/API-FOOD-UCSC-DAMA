<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consejo;
use Illuminate\Http\Request;

class ConsejoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Consejo::all());
    }

    public function store(Request $request)
    {
        return response()->json(Consejo::create($request->validate([
            'descripcion' => ['required', 'string'],
            'categoria' => ['required', 'string', 'max:255'],
        ])), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Consejo::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consejo = Consejo::findOrFail($id);
        $consejo->update($request->validate([
            'descripcion' => ['sometimes', 'string'],
            'categoria' => ['sometimes', 'string', 'max:255'],
        ]));

        return response()->json($consejo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Consejo::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}
