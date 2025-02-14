<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes, HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nom', 
        'prenom', 
        'Matricule',
        'telephone', 
        'login', 
        'password', 
        'role_id', 
        'email',
        'first_connexion',
        'isActive',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts= [
        'first_connexion'=> 'boolean'
    ];
    protected $dates = ['deleted_at'];
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
    public function campagnes()
    {
        return $this->hasMany(Campagne::class);
    }

  
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}


