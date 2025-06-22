<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pinjaman_id',
        'bulan_ke',
        'pokok',
        'bunga',
        'total_angsuran',
        'tanggal_jatuh_tempo',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(PengajuanPeminjaman::class, 'pinjaman_id');
    }
}
