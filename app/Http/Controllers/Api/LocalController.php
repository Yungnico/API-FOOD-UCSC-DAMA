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
        $local = Local::create($request->all());

        return response()->json($local, 201);
    }

    public function show($id)
    {
        return response()->json(Local::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $local = Local::findOrFail($id);
        $local->update($request->all());

        return response()->json($local);
    }

    public function destroy($id)
    {
        Local::destroy($id);

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}