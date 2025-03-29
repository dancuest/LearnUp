<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'costo',
        'cantidad_alumnos',
    ];

    /**
     * Many users can to belongs to the course
     */
    public function userEstudia(): BelongsToMany {
        return $this -> belongsToMany(User::class);
    }

    /**
     * Many users can to teach a course
     */
    public function userEnsena(): BelongsTo {
        return $this -> belongsToMany(User::class);
    }

    /**
     * Courses belongs to a institution
     */
    public function cursosInstitucion(): BelongsTo {
        return $this -> belongsTo(Institucion::class);
    }

    /**
     * An course has many activities
     */
    public function entregables(): HasMany {
        return $this -> hasMany(Entregable::class);
    }

    /**
     * An course has many forms
     */
    public function forms(): HasMany {
        return $this -> hasMany(Formulario::class);
    }

    /**
     * Course has an asset
     */
    public function asset(): HasOne {
        return $this -> hasOne(Asset::class);
    }
}
