<?php

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    protected $fillable = ['nombre', 'color', 'icono'];

    public function eventos()
    {
        return $this->hasMany(EventoCalendario::class);
    }
}
