<?php

use App\Models\Curso;
use App\Models\Entregable;
use App\Models\Formulario;
use Illuminate\Database\Eloquent\Model;

class EventoCalendario extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'inicio',
        'fin',
        'tipo',
        'tipo_evento_id',
        'curso_id',
        'creado_por',
        'entregable_id',
        'formulario_id'
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function entregable()
    {
        return $this->belongsTo(Entregable::class);
    }

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function tipoEvento()
    {
        return $this->belongsTo(tipoEvento::class);
    }
}
