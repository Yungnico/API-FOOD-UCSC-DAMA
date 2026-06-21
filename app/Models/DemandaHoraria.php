<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandaHoraria extends Model
{
    protected $table = 'demanda_horaria';

    protected $fillable = [
        'local_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'nivel_demanda',
    ];

    public function local()
    {
        return $this->belongsTo(Local::class, 'local_id');
    }
}