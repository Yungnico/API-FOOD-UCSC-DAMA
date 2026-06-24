<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\Consejo;
use App\Models\Desafio;
use App\Models\Favorito;
use App\Models\Local;
use App\Models\MenuProducto;
use App\Models\Reporte;
use App\Models\User;
use App\Models\UsuarioDesafio;
use Illuminate\Database\Seeder;

class FoodEngagementSeeder extends Seeder
{
    public function run(): void
    {
        $tips = [
            ['descripcion' => 'Incluye al menos una porción de verduras en cada almuerzo.', 'categoria' => 'balance'],
            ['descripcion' => 'Prioriza agua o bebidas sin azúcar antes que opciones azucaradas.', 'categoria' => 'hidratacion'],
            ['descripcion' => 'Revisa el sodio si buscas comer más liviano durante la semana.', 'categoria' => 'salud'],
            ['descripcion' => 'Combina proteínas, carbohidratos y fibra para quedar satisfecho por más tiempo.', 'categoria' => 'energia'],
            ['descripcion' => 'Si el local está muy lleno, revisa opciones para llevar y evitar filas.', 'categoria' => 'tiempo'],
            ['descripcion' => 'Una fruta al día ayuda a completar tu colación con mejor perfil nutricional.', 'categoria' => 'colacion'],
        ];

        foreach ($tips as $tip) {
            Consejo::updateOrCreate(
                [
                    'descripcion' => $tip['descripcion'],
                ],
                [
                    'categoria' => $tip['categoria'],
                ]
            );
        }

        $challenges = [
            [
                'titulo' => '3 almuerzos sin frituras',
                'descripcion' => 'Durante la semana elige tres almuerzos con preparaciones al horno, plancha o vapor.',
                'recompensa_puntos' => 60,
                'reglas_json' => ['tipo' => 'sin_frituras', 'objetivo' => 3, 'periodo' => 'semana'],
            ],
            [
                'titulo' => 'Hidratación activa',
                'descripcion' => 'Acompaña tus comidas con agua durante cuatro días seguidos.',
                'recompensa_puntos' => 40,
                'reglas_json' => ['tipo' => 'agua', 'objetivo' => 4, 'periodo' => 'semana'],
            ],
            [
                'titulo' => 'Día verde',
                'descripcion' => 'Elige una opción con verduras en dos comidas del mismo día.',
                'recompensa_puntos' => 30,
                'reglas_json' => ['tipo' => 'verduras', 'objetivo' => 2, 'periodo' => 'dia'],
            ],
            [
                'titulo' => 'Colación consciente',
                'descripcion' => 'Reemplaza una colación dulce por fruta o yogurt natural.',
                'recompensa_puntos' => 25,
                'reglas_json' => ['tipo' => 'colacion_saludable', 'objetivo' => 1, 'periodo' => 'dia'],
            ],
        ];

        foreach ($challenges as $challenge) {
            Desafio::updateOrCreate(
                ['titulo' => $challenge['titulo']],
                [
                    'descripcion' => $challenge['descripcion'],
                    'recompensa_puntos' => $challenge['recompensa_puntos'],
                    'reglas_json' => $challenge['reglas_json'],
                ]
            );
        }

        $users = [
            User::where('email', 'test@example.com')->first(),
            User::where('email', 'ana@example.com')->first(),
            User::where('email', 'carlos@example.com')->first(),
            User::where('email', 'maria@example.com')->first(),
        ];

        $favorites = [
            'test@example.com' => ['Almuerzo Ejecutivo', 'Jugo Natural'],
            'ana@example.com' => ['Ensalada Mediterránea', 'Yogurt con Fruta'],
            'carlos@example.com' => ['Hamburguesa Casera', 'Pizza Margarita'],
            'maria@example.com' => ['Bowl Vegano', 'Wrap Sin Gluten'],
        ];

        foreach ($favorites as $email => $productNames) {
            $user = User::where('email', $email)->first();
            if ($user === null) {
                continue;
            }

            foreach ($productNames as $productName) {
                $productId = MenuProducto::query()
                    ->whereHas('producto', fn ($query) => $query->where('nombre', $productName))
                    ->value('producto_id');

                if ($productId === null) {
                    continue;
                }

                Favorito::updateOrCreate(
                    [
                        'usuario_id' => $user->id,
                        'producto_id' => $productId,
                    ]
                );
            }
        }

        $reportes = [
            ['email' => 'test@example.com', 'local' => 'Casino Central', 'descripcion' => 'El menú mostrado no coincide con el plato disponible en mostrador.'],
            ['email' => 'ana@example.com', 'local' => 'Cafetería Biblioteca', 'descripcion' => 'Faltó actualizar el horario de atención en la tarde.'],
            ['email' => 'maria@example.com', 'local' => 'Kiosko Saludable', 'descripcion' => 'Un producto aparece agotado pero sigue visible como disponible.'],
        ];

        foreach ($reportes as $reporte) {
            $user = User::where('email', $reporte['email'])->first();
            $local = Local::where('nombre', $reporte['local'])->first();

            if ($user === null || $local === null) {
                continue;
            }

            Reporte::updateOrCreate(
                [
                    'usuario_id' => $user->id,
                    'local_id' => $local->id,
                    'descripcion' => $reporte['descripcion'],
                ],
                [
                    'estado' => 'pendiente',
                ]
            );
        }

        $compraSeedData = [
            ['email' => 'test@example.com', 'local' => 'Casino Central', 'producto' => 'Almuerzo Ejecutivo', 'fecha' => now()->subDays(3)->setTime(13, 10)],
            ['email' => 'ana@example.com', 'local' => 'Kiosko Saludable', 'producto' => 'Ensalada Mediterránea', 'fecha' => now()->subDays(2)->setTime(12, 40)],
            ['email' => 'carlos@example.com', 'local' => 'Pizzería Express', 'producto' => 'Pizza Margarita', 'fecha' => now()->subDay()->setTime(20, 5)],
            ['email' => 'maria@example.com', 'local' => 'Cafetería Biblioteca', 'producto' => 'Yogurt con Fruta', 'fecha' => now()->subDay()->setTime(10, 20)],
        ];

        foreach ($compraSeedData as $seed) {
            $user = User::where('email', $seed['email'])->first();
            $menuProducto = MenuProducto::query()
                ->whereHas('menu.local', fn ($query) => $query->where('nombre', $seed['local']))
                ->whereHas('producto', fn ($query) => $query->where('nombre', $seed['producto']))
                ->first();

            if ($user === null || $menuProducto === null) {
                continue;
            }

            Compra::updateOrCreate(
                [
                    'usuario_id' => $user->id,
                    'menu_producto_id' => $menuProducto->id,
                    'fecha_compra' => $seed['fecha'],
                ],
                [
                    'calificacion' => 5,
                ]
            );
        }

        $challengeAssignments = [
            ['email' => 'test@example.com', 'challenge' => '3 almuerzos sin frituras', 'estado' => 'en_progreso'],
            ['email' => 'ana@example.com', 'challenge' => 'Hidratación activa', 'estado' => 'completado'],
            ['email' => 'maria@example.com', 'challenge' => 'Día verde', 'estado' => 'en_progreso'],
        ];

        foreach ($challengeAssignments as $assignment) {
            $user = User::where('email', $assignment['email'])->first();
            $challenge = Desafio::where('titulo', $assignment['challenge'])->first();

            if ($user === null || $challenge === null) {
                continue;
            }

            UsuarioDesafio::updateOrCreate(
                [
                    'usuario_id' => $user->id,
                    'desafio_id' => $challenge->id,
                ],
                [
                    'estado' => $assignment['estado'],
                    'fecha_inicio' => now()->subDays(5)->toDateString(),
                    'fecha_fin' => $assignment['estado'] === 'completado' ? now()->subDay()->toDateString() : null,
                ]
            );
        }
    }
}
