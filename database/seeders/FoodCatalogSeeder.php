<?php

namespace Database\Seeders;

use App\Models\CategoriaComida;
use App\Models\InformacionNutricional;
use App\Models\Local;
use App\Models\Menu;
use App\Models\MenuProducto;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class FoodCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $baseDate = now()->toDateString();

        $categories = [
            'Económica',
            'Vegetariana',
            'Vegana',
            'Casera',
            'Sin gluten',
            'Saludable',
            'Comida rápida',
            'Bebidas',
            'Postres',
            'Desayunos',
        ];

        $categoryModels = [];
        foreach ($categories as $name) {
            $categoryModels[$name] = CategoriaComida::updateOrCreate([
                'nombre' => $name,
            ]);
        }

        $locales = [
            [
                'nombre' => 'Casino Central',
                'descripcion' => 'Opciones de almuerzo para estudiantes, docentes y funcionarios.',
                'horario' => '08:00 - 18:00',
                'contacto' => 'casino.central@ucsc.cl',
                'latitude' => -36.8221100,
                'longitude' => -73.0447800,
                'tiempo_espera_estimado' => 18,
            ],
            [
                'nombre' => 'Cafetería Biblioteca',
                'descripcion' => 'Café, sándwiches y colaciones rápidas.',
                'horario' => '09:00 - 20:00',
                'contacto' => 'cafeteria.biblioteca@ucsc.cl',
                'latitude' => -36.8214500,
                'longitude' => -73.0453500,
                'tiempo_espera_estimado' => 10,
            ],
            [
                'nombre' => 'Kiosko Saludable',
                'descripcion' => 'Alternativas livianas, ensaladas y jugos naturales.',
                'horario' => '09:00 - 17:00',
                'contacto' => 'kiosko.saludable@ucsc.cl',
                'latitude' => -36.8208800,
                'longitude' => -73.0439200,
                'tiempo_espera_estimado' => 8,
            ],
            [
                'nombre' => 'Pizzería Express',
                'descripcion' => 'Pizzas, platos rápidos y promociones por porción.',
                'horario' => '11:00 - 22:00',
                'contacto' => 'pizzeria.express@ucsc.cl',
                'latitude' => -36.8230000,
                'longitude' => -73.0461000,
                'tiempo_espera_estimado' => 24,
            ],
        ];

        $localModels = [];
        foreach ($locales as $data) {
            $localModels[$data['nombre']] = Local::updateOrCreate(
                ['nombre' => $data['nombre']],
                $data
            );
        }

        $products = [
            [
                'nombre' => 'Almuerzo Ejecutivo',
                'descripcion' => 'Entrada, fondo y acompañamiento del día.',
                'categoria_basica' => 'Casera',
                'stock' => 60,
                'precio_base' => 3900,
                'categorias' => ['Casera', 'Económica'],
                'nutricion' => [520, 28, 56, 18, 720, 74],
            ],
            [
                'nombre' => 'Ensalada Mediterránea',
                'descripcion' => 'Mix de hojas verdes, tomate, aceitunas y proteína vegetal.',
                'categoria_basica' => 'Saludable',
                'stock' => 35,
                'precio_base' => 4500,
                'categorias' => ['Vegetariana', 'Saludable'],
                'nutricion' => [280, 12, 20, 14, 320, 88],
            ],
            [
                'nombre' => 'Bowl Vegano',
                'descripcion' => 'Arroz integral, garbanzos, palta y vegetales salteados.',
                'categoria_basica' => 'Vegana',
                'stock' => 28,
                'precio_base' => 5200,
                'categorias' => ['Vegana', 'Saludable'],
                'nutricion' => [410, 15, 45, 16, 360, 92],
            ],
            [
                'nombre' => 'Wrap Sin Gluten',
                'descripcion' => 'Tortilla sin gluten con pollo, tomate y hojas verdes.',
                'categoria_basica' => 'Sin gluten',
                'stock' => 24,
                'precio_base' => 4900,
                'categorias' => ['Sin gluten', 'Saludable'],
                'nutricion' => [360, 24, 28, 13, 430, 85],
            ],
            [
                'nombre' => 'Hamburguesa Casera',
                'descripcion' => 'Hamburguesa artesanal con papas rústicas.',
                'categoria_basica' => 'Comida rápida',
                'stock' => 40,
                'precio_base' => 5500,
                'categorias' => ['Comida rápida', 'Casera'],
                'nutricion' => [690, 32, 58, 34, 820, 58],
            ],
            [
                'nombre' => 'Pizza Margarita',
                'descripcion' => 'Masa artesanal con tomate, mozzarella y albahaca.',
                'categoria_basica' => 'Comida rápida',
                'stock' => 18,
                'precio_base' => 6200,
                'categorias' => ['Comida rápida'],
                'nutricion' => [750, 26, 74, 32, 910, 54],
            ],
            [
                'nombre' => 'Jugo Natural',
                'descripcion' => 'Jugo de fruta de temporada sin azúcar añadida.',
                'categoria_basica' => 'Bebidas',
                'stock' => 45,
                'precio_base' => 1800,
                'categorias' => ['Bebidas', 'Saludable'],
                'nutricion' => [120, 1, 28, 0, 20, 95],
            ],
            [
                'nombre' => 'Café Americano',
                'descripcion' => 'Café filtrado clásico.',
                'categoria_basica' => 'Bebidas',
                'stock' => 70,
                'precio_base' => 1400,
                'categorias' => ['Bebidas'],
                'nutricion' => [5, 0, 1, 0, 2, 99],
            ],
            [
                'nombre' => 'Yogurt con Fruta',
                'descripcion' => 'Yogurt natural con fruta fresca y avena.',
                'categoria_basica' => 'Saludable',
                'stock' => 32,
                'precio_base' => 2300,
                'categorias' => ['Saludable', 'Económica'],
                'nutricion' => [210, 10, 26, 6, 90, 90],
            ],
            [
                'nombre' => 'Sopa del Día',
                'descripcion' => 'Preparación casera liviana para acompañar el almuerzo.',
                'categoria_basica' => 'Casera',
                'stock' => 22,
                'precio_base' => 2600,
                'categorias' => ['Casera', 'Económica'],
                'nutricion' => [180, 7, 22, 6, 510, 82],
            ],
            [
                'nombre' => 'Pasta Boloñesa',
                'descripcion' => 'Pasta con salsa boloñesa y queso rallado.',
                'categoria_basica' => 'Casera',
                'stock' => 26,
                'precio_base' => 5400,
                'categorias' => ['Casera'],
                'nutricion' => [640, 27, 78, 20, 680, 61],
            ],
            [
                'nombre' => 'Brownie de Avena',
                'descripcion' => 'Postre casero con avena y cacao.',
                'categoria_basica' => 'Postres',
                'stock' => 20,
                'precio_base' => 1900,
                'categorias' => ['Postres', 'Económica'],
                'nutricion' => [260, 5, 36, 10, 140, 55],
            ],
        ];

        $productModels = [];
        foreach ($products as $data) {
            $product = Producto::updateOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'descripcion' => $data['descripcion'],
                    'categoria_basica' => $data['categoria_basica'],
                    'stock' => $data['stock'],
                    'precio_base' => $data['precio_base'],
                ]
            );

            $productModels[$data['nombre']] = $product;

            $categoryIds = array_map(
                fn (string $categoryName) => $categoryModels[$categoryName]->id,
                $data['categorias']
            );
            $product->categorias()->sync($categoryIds);

            InformacionNutricional::updateOrCreate(
                ['producto_id' => $product->id],
                [
                    'calorias' => $data['nutricion'][0],
                    'proteina' => $data['nutricion'][1],
                    'carbohidratos' => $data['nutricion'][2],
                    'grasas' => $data['nutricion'][3],
                    'sodio' => $data['nutricion'][4],
                    'puntaje' => $data['nutricion'][5],
                ]
            );
        }

        $menus = [
            [
                'local' => 'Casino Central',
                'titulo' => 'Menú del día',
                'promociones' => '10% de descuento con credencial al pagar antes de las 13:30.',
                'items' => [
                    ['producto' => 'Almuerzo Ejecutivo', 'precio_venta' => 3900, 'disponible' => true],
                    ['producto' => 'Sopa del Día', 'precio_venta' => 2600, 'disponible' => true],
                    ['producto' => 'Jugo Natural', 'precio_venta' => 1800, 'disponible' => true],
                ],
            ],
            [
                'local' => 'Cafetería Biblioteca',
                'titulo' => 'Colaciones y café',
                'promociones' => 'Combo café + brownie con precio preferencial.',
                'items' => [
                    ['producto' => 'Café Americano', 'precio_venta' => 1400, 'disponible' => true],
                    ['producto' => 'Brownie de Avena', 'precio_venta' => 1900, 'disponible' => true],
                    ['producto' => 'Yogurt con Fruta', 'precio_venta' => 2300, 'disponible' => true],
                ],
            ],
            [
                'local' => 'Kiosko Saludable',
                'titulo' => 'Opciones balanceadas',
                'promociones' => 'Descuento en bowls y wraps para estudiantes.',
                'items' => [
                    ['producto' => 'Ensalada Mediterránea', 'precio_venta' => 4500, 'disponible' => true],
                    ['producto' => 'Bowl Vegano', 'precio_venta' => 5200, 'disponible' => true],
                    ['producto' => 'Wrap Sin Gluten', 'precio_venta' => 4900, 'disponible' => true],
                ],
            ],
            [
                'local' => 'Pizzería Express',
                'titulo' => 'Especial de la casa',
                'promociones' => '2x1 en porciones seleccionadas después de las 19:00.',
                'items' => [
                    ['producto' => 'Pizza Margarita', 'precio_venta' => 6200, 'disponible' => true],
                    ['producto' => 'Hamburguesa Casera', 'precio_venta' => 5500, 'disponible' => true],
                    ['producto' => 'Jugo Natural', 'precio_venta' => 1800, 'disponible' => true],
                ],
            ],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::updateOrCreate(
                [
                    'local_id' => $localModels[$menuData['local']]->id,
                    'fecha' => $baseDate,
                    'titulo' => $menuData['titulo'],
                ],
                [
                    'promociones' => $menuData['promociones'],
                ]
            );

            foreach ($menuData['items'] as $item) {
                MenuProducto::updateOrCreate(
                    [
                        'menu_id' => $menu->id,
                        'producto_id' => $productModels[$item['producto']]->id,
                    ],
                    [
                        'precio_venta' => $item['precio_venta'],
                        'disponible' => $item['disponible'],
                    ]
                );
            }
        }

        foreach ($localModels as $local) {
            $days = [1, 2, 3, 4, 5];
            foreach ($days as $day) {
                $levels = [
                    ['hora_inicio' => '08:00:00', 'hora_fin' => '10:30:00', 'nivel_demanda' => 'baja'],
                    ['hora_inicio' => '12:30:00', 'hora_fin' => '14:30:00', 'nivel_demanda' => 'alta'],
                    ['hora_inicio' => '18:00:00', 'hora_fin' => '20:00:00', 'nivel_demanda' => 'media'],
                ];

                foreach ($levels as $level) {
                    $local->demandaHoraria()->updateOrCreate(
                        [
                            'dia_semana' => $day,
                            'hora_inicio' => $level['hora_inicio'],
                        ],
                        [
                            'hora_fin' => $level['hora_fin'],
                            'nivel_demanda' => $level['nivel_demanda'],
                        ]
                    );
                }
            }
        }
    }
}
