<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['sometimes', 'nullable', 'string', 'max:255'],
            'apellido_materno' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'objetivos_salud' => ['sometimes', 'nullable', 'string'],
            'calorias_target' => ['sometimes', 'nullable', 'integer', 'min:0'],
        ]);

        $user = User::create([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'] ?? '',
            'apellido_materno' => $data['apellido_materno'] ?? '',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'objetivos_salud' => $data['objetivos_salud'] ?? null,
            'calorias_target' => $data['calorias_target'] ?? 0,
        ]);

        $token = $user->createToken('android')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales invalidas',
            ], 422);
        }

        $token = $user->createToken('android')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function nutritionSummary(Request $request)
    {
        $user = $request->user();

        if ($user === null) {
            abort(401, 'Debes iniciar sesión para ver el resumen nutricional.');
        }

        $purchases = Compra::with(['menuProducto.producto.informacionNutricional', 'menuProducto.menu.local'])
            ->where('usuario_id', $user->id)
            ->latest('fecha_compra')
            ->get();

        $dailyCalories = $purchases
            ->filter(fn (Compra $purchase) => $purchase->fecha_compra?->isSameDay(now()) ?? false)
            ->sum(fn (Compra $purchase) => $this->purchaseCalories($purchase));

        $weeklyData = collect(range(6, 0))->map(function (int $daysAgo) use ($purchases) {
            $date = now()->subDays($daysAgo)->startOfDay();

            return [
                'date' => $this->dayLabel($date),
                'calories' => $purchases
                    ->filter(fn (Compra $purchase) => $purchase->fecha_compra?->isSameDay($date) ?? false)
                    ->sum(fn (Compra $purchase) => $this->purchaseCalories($purchase)),
            ];
        })->values();

        $purchasedItems = $purchases->take(6)->map(function (Compra $purchase) {
            return [
                'name' => $purchase->menuProducto?->producto?->nombre ?? 'Producto',
                'calories' => $this->purchaseCalories($purchase),
                'local' => $purchase->menuProducto?->menu?->local?->nombre,
                'date' => $purchase->fecha_compra?->toDateString(),
            ];
        })->values();

        return response()->json([
            'daily_calories' => $dailyCalories,
            'calorie_goal' => $user->calorias_target ?? 2200,
            'weekly_data' => $weeklyData,
            'purchased_items' => $purchasedItems,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Sesion cerrada',
        ]);
    }

    private function purchaseCalories(Compra $purchase): int
    {
        return (int) ($purchase->menuProducto?->producto?->informacionNutricional?->calorias ?? 0);
    }

    private function dayLabel($date): string
    {
        return ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'][(int) $date->dayOfWeek];
    }
}
