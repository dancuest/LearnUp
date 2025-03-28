<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion'
    ];

    public function form(): BelongsTo{
        return $this -> belongsTo(Formulario::class);
    }

    public function respuesta(): HasMany {
        return $this -> hasMany(Respuesta::class);
    }

    public function opciones(): HasMany {
        return $this -> hasMany(Opcion::class);
    }
}
