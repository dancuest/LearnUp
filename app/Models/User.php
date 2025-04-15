<?php

namespace App\Models;

use App\Models\EventoCalendario;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'fecha_nacimiento',
        'sexo',
        'imagen_perfil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'date'
    ];

    /* Relaciones */
    public function institucionesCreadas()
    {
        return $this->hasMany(Institucion::class, 'user_id');
    }

    public function instituciones()
    {
        return $this->belongsToMany(Institucion::class, 'accede_institucion_user')
            ->withPivot(['rol', 'estado', 'estado_pago', 'fecha_pago']);
    }

    public function cursosComoDocente()
    {
        return $this->hasMany(Curso::class, 'docente_id');
    }

    public function cursosInscritos()
    {
        return $this->belongsToMany(Curso::class, 'estudia_curso_user');
    }

    public function entregablesAsignados()
    {
        return $this->hasMany(Entregable::class, 'user_id');
    }

    public function formulariosAsignados()
    {
        return $this->hasMany(Formulario::class, 'user_id');
    }

    public function eventosCreados()
    {
        return $this->hasMany(EventoCalendario::class, 'creado_por');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /* Scopes útiles */
    public function scopeDocentes($query)
    {
        return $query->whereHas('instituciones', function ($q) {
            $q->where('rol', 'docente');
        });
    }
}
