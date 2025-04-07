<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'msisdn',
        'solde',
        'email',
        'user_first_name',
        'user_last_name',
        'sex',
        'registered_on'
    ];

    protected $casts = [
        'registered_on' => 'datetime',
    ];
}
