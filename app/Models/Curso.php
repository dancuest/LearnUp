<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'costo',
        'cantidad_alumnos',
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    /**
     * Many users can to belongs to the course
     */
    public function userEstudia(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'estudia_curso_user');
    }

    /**
     * Many users can to teach a course
     */
    public function userEnsena(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Courses belongs to a institution
     */
    public function cursosInstitucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * An course has many activities
     */
    public function entregables(): HasMany
    {
        return $this->hasMany(Entregable::class);
    }

    /**
     * An course has many forms
     */
    public function forms(): HasMany
    {
        return $this->hasMany(Formulario::class);
    }

    /**
     * Course has an asset
     */
    public function asset(): HasOne
    {
        return $this->hasOne(Asset::class);
    }
}
