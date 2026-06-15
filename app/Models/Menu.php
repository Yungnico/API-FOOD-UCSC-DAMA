<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'local_id',
        'nombre',
        'descripcion',
        'promociones'
    ];

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'menu_producto'
        );
    }
}