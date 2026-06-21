<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'usuario_id',
        'menu_producto_id',
        'fecha_compra',
        'calificacion',
    ];

    protected $casts = [
        'fecha_compra' => 'datetime',
        'calificacion' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function menuProducto()
    {
        return $this->belongsTo(MenuProducto::class);
    }
}