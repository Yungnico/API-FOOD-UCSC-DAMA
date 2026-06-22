<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Producto;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::with(['local', 'productos'])->get());
    }

    public function menusPorLocal($id)
    {
        return response()->json(
            Menu::with(['local', 'productos'])
                ->where('local_id', $id)
                ->orderByDesc('fecha')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $menu = Menu::create($request->validate([
            'local_id' => ['required', 'exists:locales,id'],
            'fecha' => ['required', 'date'],
            'titulo' => ['required', 'string', 'max:255'],
            'promociones' => ['nullable', 'string'],
        ]));

        if ($request->has('productos')) {
            $menu->productos()->sync($this->normalizarProductos($request->input('productos')));
        }

        return response()->json($menu, 201);
    }

    public function show($id)
    {
        return response()->json(Menu::with(['local', 'productos'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update($request->validate([
            'local_id' => ['sometimes', 'exists:locales,id'],
            'fecha' => ['sometimes', 'date'],
            'titulo' => ['sometimes', 'string', 'max:255'],
            'promociones' => ['sometimes', 'nullable', 'string'],
        ]));

        if ($request->has('productos')) {
            $menu->productos()->sync($this->normalizarProductos($request->input('productos')));
        }

        return response()->json($menu);
    }

    public function destroy($id)
    {
        Menu::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }

    private function normalizarProductos(array $productos): array
    {
        $resultado = [];

        foreach ($productos as $producto) {
            if (is_array($producto)) {
                $productoId = $producto['producto_id'] ?? $producto['id'] ?? null;

                if ($productoId === null) {
                    continue;
                }

                $resultado[$productoId] = [
                    'precio_venta' => $producto['precio_venta'] ?? Producto::findOrFail($productoId)->precio_base,
                    'disponible' => $producto['disponible'] ?? true,
                ];

                continue;
            }

            $productoModel = Producto::findOrFail($producto);

            $resultado[$productoModel->id] = [
                'precio_venta' => $productoModel->precio_base,
                'disponible' => true,
            ];
        }

        return $resultado;
    }
}