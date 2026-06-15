<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locals';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'descripcion',
        'horario',
        'contacto',
        'tiempo_espera'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}