<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion'
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Formulario::class);
    }

    public function respuesta(): HasMany
    {
        return $this->hasMany(Respuesta::class);
    }

    public function opciones(): HasMany
    {
        return $this->hasMany(Opcion::class);
    }
}
