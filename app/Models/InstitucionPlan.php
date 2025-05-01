<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InstitucionPlan extends Pivot
{
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];
}
