<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'horario',
        'contacto',
        'latitude',
        'longitude',
        'tiempo_espera_estimado'
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'tiempo_espera_estimado' => 'integer',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }

    public function demandaHoraria()
    {
        return $this->hasMany(DemandaHoraria::class, 'local_id');
    }
}