<?php

namespace App\Models;

use App\Models\InstitucionPlan as ModelsInstitucionPlan;
use App\Models\Plan as ModelsPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use InstitucionPlan;
use Plan;

class Institucion extends Model
{
    use HasFactory;
    protected $table = 'instituciones';
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'capacidad',
        'capacidad_limite',
        'imagen_perfil',
        'user_id'
    ];

    protected $casts = [
        'capacidad_limite' => 'boolean'
    ];

    /* Relaciones */
    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function miembros()
    {
        return $this->belongsToMany(User::class, 'accede_institucion_user')
            ->withPivot(['rol', 'estado', 'estado_pago', 'fecha_pago']);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function planes()
    {
        return $this->belongsToMany(ModelsPlan::class, 'institucion_plan')
            ->using(ModelsInstitucionPlan::class)
            ->withPivot(['fecha_inicio', 'fecha_fin', 'estado', 'renovacion_automatica']);
    }

    public function planActual()
    {
        return $this->planes()
            ->wherePivot('estado', 'activo')
            ->orderByPivot('fecha_fin', 'desc')
            ->first();
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /* Métodos útiles */
    public function esPublica()
    {
        return $this->tipo === 'publico';
    }

    public function capacidadDisponible()
    {
        if (!$this->capacidad_limite) {
            return PHP_INT_MAX;
        }

        return $this->capacidad - $this->miembros()->count();
    }

    public function docentes()
    {
        return $this->belongsToMany(User::class, 'accede_institucion_user')
            ->wherePivot('rol', 'docente')
            ->withPivot(['estado', 'estado_pago', 'fecha_pago']);
    }
}
