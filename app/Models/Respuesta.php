<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'esCorrecto'
    ];

    public function pregunta(): BelongsTo {
        return $this->belongsTo(Pregunta::class);
    }

    public function opcion(): BelongsTo {
        return $this->belongsTo(Opcion::class);
    }

    public function intento(): BelongsTo {
        return $this->belongsTo(Intento::class);
    }
}
