<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioDesafio extends Model
{
    protected $table = 'usuario_desafio';

    protected $fillable = [
        'usuario_id',
        'desafio_id',
        'estado',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function desafio()
    {
        return $this->belongsTo(Desafio::class);
    }
}