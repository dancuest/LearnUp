<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Institucion extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'nombre',
        'tipo',
        'capacidad',
        'imagen_perfil',
        'descripcion',
    ];

    /**
     * An institution belongs to a user
     */
    public function userCreaInstitucion(): BelongsTo {
        return $this -> belongsTo(User::class);
    }

    /**
     * Many users can to access to the institution
     */
    public function userAccedeInstitucion(): BelongsToMany {
        return $this -> belongsToMany(User::class);
    }

    /**
     * 
     */
    public function pago(): HasOne {
        return $this -> hasOne(Pago::class);
    }

    /**
     * An institution has many courses 
     */
    public function cursos(): HasMany {
        return $this -> hasMany(Curso::class);
    }
}
