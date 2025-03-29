<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto',
        'fecha',
        'metodo',
    ];

    /**
     * One pay belongs to an user 
     */
    public function pagos(): BelongsTo {
        return $this -> belongsTo(User::class);
    }

    /**
     * 
     */
    public function InstitucionAccedepago(): BelongsTo {
        return $this -> belongsTo(Institucion::class);
    }
}
