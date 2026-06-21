<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuProducto extends Model
{
    protected $table = 'menu_producto';

    protected $fillable = [
        'menu_id',
        'producto_id',
        'precio_venta',
        'disponible',
    ];

    protected $casts = [
        'precio_venta' => 'decimal:2',
        'disponible' => 'boolean',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}