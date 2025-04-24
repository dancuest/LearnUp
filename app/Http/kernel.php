<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [

        'validar.creador.institucion' => \App\Http\Middleware\ValidarCreadorInstitucion::class,
        'validar.docente.curso' => \App\Http\Middleware\ValidarDocenteCurso::class,
    ];
}
