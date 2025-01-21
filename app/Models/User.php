<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts= [
        'first_connexion'=> 'boolean'
    ];
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


