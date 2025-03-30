<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota',
    ];

    /**
     * An attemp (intento) is perform by an user
     */
    public function userRealizaIntento(): BelongsTo {
        return $this -> belongsTo(User::class);
    }

    public function respuesta(): HasMany {
        return $this->hasMany(Respuesta::class);
    }

    public function form(): BelongsTo {
        return $this->belongsTo(Formulario::class);
    }
}
