<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacionNutricional extends Model
{
    protected $table = 'informacion_nutricional';

    protected $fillable = [
        'producto_id',
        'calorias',
        'proteina',
        'carbohidratos',
        'grasas',
        'sodio',
        'puntaje',
    ];

    protected $casts = [
        'calorias' => 'integer',
        'proteina' => 'decimal:2',
        'carbohidratos' => 'decimal:2',
        'grasas' => 'decimal:2',
        'sodio' => 'decimal:2',
        'puntaje' => 'decimal:2',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}