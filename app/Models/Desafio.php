<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desafio extends Model
{
    protected $table = 'desafios';

    protected $fillable = [
        'titulo',
        'descripcion',
        'recompensa_puntos',
        'reglas_json',
    ];

    protected $casts = [
        'recompensa_puntos' => 'integer',
        'reglas_json' => 'array',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'usuario_desafio',
            'desafio_id',
            'usuario_id'
        )
            ->withPivot(['estado', 'fecha_inicio', 'fecha_fin'])
            ->withTimestamps();
    }

    public function participantes()
    {
        return $this->hasMany(UsuarioDesafio::class, 'desafio_id');
    }
}