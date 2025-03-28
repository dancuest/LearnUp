<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opcion extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad'
    ];

    public function pregunta(): BelongsTo {
        return $this->belongsTo(Pregunta::class);
    }

    public function respuesta(): HasMany {
        return $this->hasMany(Respuesta::class);
    }
}
