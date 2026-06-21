<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_basica',
        'stock',
        'precio_base',
    ];

    protected $casts = [
        'stock' => 'integer',
        'precio_base' => 'decimal:2',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_producto')
            ->withPivot(['id', 'precio_venta', 'disponible'])
            ->withTimestamps();
    }

    public function categorias()
    {
        return $this->belongsToMany(CategoriaComida::class, 'producto_categoria');
    }

    public function informacionNutricional()
    {
        return $this->hasOne(InformacionNutricional::class);
    }
}
