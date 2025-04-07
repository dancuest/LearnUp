<?php

use App\Models\Institucion;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['nombre', 'tipo', 'max_usuarios', 'precio_mensual', 'descripcion'];

    public function instituciones()
    {
        return $this->belongsToMany(Institucion::class)->using(InstitucionPlan::class);
    }
}
