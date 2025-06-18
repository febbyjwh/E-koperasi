<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ini penting
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Petugas extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'petugas';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
