<?php

namespace App\Models;

use EventoCalendario;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'cantidad_alumnos',
        'institucion_id'
    ];

    /* Relaciones */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'estudia_curso_user');
    }

    public function entregables()
    {
        return $this->hasMany(Entregable::class);
    }

    public function formularios()
    {
        return $this->hasMany(Formulario::class);
    }

    public function eventos()
    {
        return $this->hasMany(EventoCalendario::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /* Métodos útiles */
    public function tieneCupoDisponible()
    {
        return $this->estudiantes()->count() < $this->cantidad_alumnos;
    }

    public function costoFormateado()
    {
        return '$' . number_format($this->costo, 2);
    }
}
