<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nombre' => 'Test',
                'apellido_paterno' => 'User',
                'apellido_materno' => 'Seeder',
                'email' => 'test@example.com',
                'password' => 'password',
                'objetivos_salud' => 'comer mas verduras',
                'calorias_target' => 2200,
                'puntos' => 120,
            ],
            [
                'nombre' => 'Ana',
                'apellido_paterno' => 'Paredes',
                'apellido_materno' => 'Vega',
                'email' => 'ana@example.com',
                'password' => 'password',
                'objetivos_salud' => 'reducir azucar',
                'calorias_target' => 2000,
                'puntos' => 260,
            ],
            [
                'nombre' => 'Carlos',
                'apellido_paterno' => 'Mora',
                'apellido_materno' => 'Rojas',
                'email' => 'carlos@example.com',
                'password' => 'password',
                'objetivos_salud' => 'evitar frituras',
                'calorias_target' => 2400,
                'puntos' => 80,
            ],
            [
                'nombre' => 'Maria',
                'apellido_paterno' => 'Soto',
                'apellido_materno' => 'Diaz',
                'email' => 'maria@example.com',
                'password' => 'password',
                'objetivos_salud' => 'comer mas verduras',
                'calorias_target' => 1800,
                'puntos' => 340,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
