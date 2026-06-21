<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InformacionNutricional;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with(['menus', 'informacionNutricional', 'categorias'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'categoria_basica' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'categoria_ids' => ['sometimes', 'array'],
            'categoria_ids.*' => ['integer', 'exists:categorias_comida,id'],
            'informacion_nutricional' => ['sometimes', 'array'],
            'informacion_nutricional.calorias' => ['required_with:informacion_nutricional', 'integer', 'min:0'],
            'informacion_nutricional.proteina' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.carbohidratos' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.grasas' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.sodio' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.puntaje' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
        ]);

        $producto = DB::transaction(function () use ($validated) {
            $producto = Producto::create(collect($validated)->only([
                'nombre',
                'descripcion',
                'categoria_basica',
                'stock',
                'precio_base',
            ])->all());

            if (!empty($validated['categoria_ids'])) {
                $producto->categorias()->sync($validated['categoria_ids']);
            }

            if (!empty($validated['informacion_nutricional'])) {
                InformacionNutricional::updateOrCreate(
                    ['producto_id' => $producto->id],
                    $validated['informacion_nutricional'] + ['producto_id' => $producto->id]
                );
            }

            return $producto->load(['menus', 'informacionNutricional', 'categorias']);
        });

        return response()->json($producto, 201);
    }

    public function show($id)
    {
        return response()->json(Producto::with(['menus', 'informacionNutricional', 'categorias'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $validated = $request->validate([
            'nombre' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'nullable', 'string'],
            'categoria_basica' => ['sometimes', 'string', 'max:255'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'precio_base' => ['sometimes', 'numeric', 'min:0'],
            'categoria_ids' => ['sometimes', 'array'],
            'categoria_ids.*' => ['integer', 'exists:categorias_comida,id'],
            'informacion_nutricional' => ['sometimes', 'array'],
            'informacion_nutricional.calorias' => ['required_with:informacion_nutricional', 'integer', 'min:0'],
            'informacion_nutricional.proteina' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.carbohidratos' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.grasas' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.sodio' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
            'informacion_nutricional.puntaje' => ['required_with:informacion_nutricional', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($producto, $validated) {
            $producto->update(collect($validated)->only([
                'nombre',
                'descripcion',
                'categoria_basica',
                'stock',
                'precio_base',
            ])->all());

            if (array_key_exists('categoria_ids', $validated)) {
                $producto->categorias()->sync($validated['categoria_ids'] ?? []);
            }

            if (array_key_exists('informacion_nutricional', $validated)) {
                InformacionNutricional::updateOrCreate(
                    ['producto_id' => $producto->id],
                    $validated['informacion_nutricional'] + ['producto_id' => $producto->id]
                );
            }
        });

        $producto->load(['menus', 'informacionNutricional', 'categorias']);

        return response()->json($producto);
    }

    public function informacionNutricional($id)
    {
        $producto = Producto::with('informacionNutricional')->findOrFail($id);

        return response()->json($producto->informacionNutricional);
    }

    public function syncCategorias(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $data = $request->validate([
            'categoria_ids' => ['required', 'array'],
            'categoria_ids.*' => ['integer', 'exists:categorias_comida,id'],
        ]);

        $producto->categorias()->sync($data['categoria_ids']);
        $producto->load(['menus', 'informacionNutricional', 'categorias']);

        return response()->json($producto);
    }

    public function destroy($id)
    {
        Producto::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}