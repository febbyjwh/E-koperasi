<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabManasuka extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id',
    'nominal_masuk',
    'nominal_keluar',
    'total',
    'tanggal',
    ];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
