<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaComida extends Model
{
    protected $table = 'categorias_comida';

    protected $fillable = [
        'nombre',
    ];

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_categoria',
            'categoria_id',
            'producto_id'
        );
    }
}