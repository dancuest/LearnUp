<?php

namespace App\Models;

use App\Models\EventoCalendario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    /**
     * An course has many forms
     */
    public function forms(): HasMany
    {
        return $this->hasMany(Formulario::class);
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
