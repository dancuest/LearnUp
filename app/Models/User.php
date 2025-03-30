<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail as AuthMustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AuthMustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fecha_nacimiento',
        'sexo',
        'imagen_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * An User can to create many institutions
     */
    public function creaInstitucion(): HasMany {
        return $this -> hasMany(Institucion::class);
    }

    /**
     * An user can to access to many institutions
     */
    public function accedeInstitucion(): BelongsToMany {
        return $this -> belongsToMany(Institucion::class);
    }

    /**
     * An User can to teach in many courses
     */
    public function ensenaCurso(): BelongsToMany {
        return $this -> belongsToMany(Curso::class);
    }

    /**
     * An user can to study in many courses
     */
    public function estudiaCurso(): BelongsToMany {    
        return $this -> belongsToMany (Curso::class);
    }

    /**
     * An ser can to do many pays
     */
    public function pago(): HasMany {
        return $this -> hasMany(Pago::class);
    }

    /**
     * An user can to create many activities
     */
    public function creaEntregable(): HasMany {
        return $this -> hasMany(Entregable::class);
    }

    /**
     * An user can to create many forms
     */
    public function creaForm(): HasMany {
        return $this -> hasMany(Formulario::class);
    }

    /**
     * An user qualify many activities
     */
    public function califica(): HasMany {
        return $this -> hasMany(Entrega::class);
    }

    /**
     * An user send many activities
     */
    public function envia(): HasMany {
        return $this -> hasMany(Entrega::class);
    }

    /**
     * An user perform many attemps (intentos)
     */
    public function realizaintento(): HasMany {       
        return $this -> hasMany(Intento::class);
    }
}
