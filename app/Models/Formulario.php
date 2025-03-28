<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulario extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_asignacion',
        'fecha_limite_entrega',
        'intentos_posibles',
    ];

    /**
     * Form belongs to an user
     */
    public function userCreaForm (): BelongsTo {
        return $this -> belongsTo(User::class);
    }

    /**
     * Form belongs to an course
     */
    public  function cursos(): BelongsTo {
        return $this -> belongsTo(Curso::class);
    }
    
    public function pregunta(): HasMany {
        return $this -> hasMany(Pregunta::class);
    }

    public function intento(): HasMany {
        return $this->hasMany(Intento::class);
    }
}
