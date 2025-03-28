<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota',
        'fecha_entrega',
        'estado_calificacion',
    ];

    /**
     * An activity is qualified by an user
     */
    public function userCalifica(): BelongsTo {
        return $this -> belongsTo(User::class, 'user_califica_id');
    }

    /**
     * An activity is sent by an user
     */
    public function userEnvia(): BelongsTo {
        return $this -> belongsTo(User::class, 'user_envia_id');
    }

    public function entrega(): BelongsTo {
        return $this -> belongsTo(Entregable::class);
    }
}
