<?php

namespace App\Models;

use App\Models\EventoCalendario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
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

    public function ensenaCurso(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'docente_id');
    }

    /**
     * An user can to study in many courses
     */
    public function estudiaCurso(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'estudia_curso_user');
    }

    /**
     * An ser can to do many pays
     */
    public function pago(): HasMany
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
