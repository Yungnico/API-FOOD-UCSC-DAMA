<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with(['informacionNutricional', 'categorias'])->get());
    }

    public function store(Request $request)
    {
        return response()->json(Producto::create($request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'categoria_basica' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'precio_base' => ['required', 'numeric', 'min:0'],
        ])), 201);
    }

    public function show($id)
    {
        return response()->json(Producto::with(['informacionNutricional', 'categorias'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->validate([
            'nombre' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'nullable', 'string'],
            'categoria_basica' => ['sometimes', 'string', 'max:255'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'precio_base' => ['sometimes', 'numeric', 'min:0'],
        ]));

        return response()->json($producto);
    }

    public function destroy($id)
    {
        Producto::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}