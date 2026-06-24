<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\MenuProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        return response()->json(Compra::with(['usuario', 'menuProducto.producto', 'menuProducto.menu.local'])
            ->when(request()->filled('usuario_id'), function ($query) {
                $query->where('usuario_id', request()->integer('usuario_id'));
            })
            ->when(request()->user(), function ($query) {
                $query->where('usuario_id', request()->user()->id);
            })
            ->latest()
            ->get());
    }

    public function registrar(Request $request)
    {
        $data = $request->validate([
            'menu_producto_id' => ['required', 'exists:menu_producto,id'],
            'calificacion' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $usuario = $request->user();

        if ($usuario === null) {
            abort(401, 'Debes iniciar sesión para registrar una compra.');
        }

        $result = DB::transaction(function () use ($usuario, $data) {
            $compra = Compra::create([
                'usuario_id' => $usuario->id,
                'menu_producto_id' => $data['menu_producto_id'],
                'fecha_compra' => now(),
                'calificacion' => $data['calificacion'] ?? null,
            ]);

            $menuProducto = MenuProducto::with('producto.informacionNutricional', 'menu')
                ->find($compra->menu_producto_id);

            $info = $menuProducto->producto->informacionNutricional ?? null;

            // Puntos: base + posible bonificación por puntaje nutricional
            $points = 10;
            if ($info) {
                if (isset($info->puntaje) && $info->puntaje >= 60) {
                    $points += 5; // Bonificación por opción saludable
                }
            }

            $usuario->increment('puntos', $points);

            $hidratacion = null;
            if ($info && isset($info->sodio) && $info->sodio >= 400) {
                $hidratacion = 'Elegiste un plato alto en sodio. Acompáñalo con un vaso de agua adicional.';
            }

            return [
                'compra' => $compra->load(['usuario', 'menuProducto.producto', 'menuProducto.menu.local']),
                'puntos_otorgados' => $points,
                'mensaje_hidratacion' => $hidratacion,
            ];
        });

        return response()->json($result, 201);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuario_id' => ['sometimes', 'exists:users,id'],
            'menu_producto_id' => ['required', 'exists:menu_producto,id'],
            'fecha_compra' => ['sometimes', 'date'],
            'calificacion' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $data['usuario_id'] = $request->user()?->id ?? $data['usuario_id'] ?? null;

        if ($data['usuario_id'] === null) {
            abort(422, 'Debe existir un usuario autenticado o enviarse usuario_id.');
        }

        $data['fecha_compra'] = $data['fecha_compra'] ?? now();

        $compra = Compra::create($data);

        return response()->json($compra, 201);
    }

    public function show(string $id)
    {
        return response()->json(Compra::with(['usuario', 'menuProducto.producto', 'menuProducto.menu.local'])->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $compra = Compra::findOrFail($id);
        $compra->update($request->validate([
            'usuario_id' => ['sometimes', 'exists:users,id'],
            'menu_producto_id' => ['sometimes', 'exists:menu_producto,id'],
            'fecha_compra' => ['sometimes', 'date'],
            'calificacion' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]));

        return response()->json($compra);
    }

    public function destroy(string $id)
    {
        Compra::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}