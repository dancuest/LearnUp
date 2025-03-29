<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
    ];

    public function course(): BelongsTo {
        return $this -> belongsTo(Curso::class);
    }

}
