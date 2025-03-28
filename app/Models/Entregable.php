<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Entregable extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_asignacion',
        'fecha_limite_entrega',
    ];

    /**
     * An activity belongs to an user
     */
    public function userCreaEntregable(): belongsTo {
        return $this -> belongsTo(User::class);
    }

    /**
     * an activity belongs to a course
     */
    public function cursos(): BelongsTo {
        return $this -> belongsTo(Curso::class);
    }

    /**
     * An activity has many activities delivered
     */
    public function entrega(): HasMany {
        return $this -> hasMany(Entrega::class);
    }
}
