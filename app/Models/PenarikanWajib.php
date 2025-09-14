<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanWajib extends Model
{
    use HasFactory;

    protected $table = 'penarikan_wajib';

    protected $fillable = [
        'user_id',
        'total_ditarik',
        'tanggal_penarikan',
        'keterangan',
    ];

    // Relasi ke User (anggota)
    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}