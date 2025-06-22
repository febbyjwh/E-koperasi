<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPinjaman extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pinjaman';

    protected $fillable = [
    'user_id',
    'jumlah',
    'lama_angsuran',
    'tujuan',
    'jenis_pinjaman',
    'potongan_propisi',
    'total_jasa',
    'cicilan_per_bulan',
    'tanggal_pengajuan',
    'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelunasan()
    {
        return $this->hasMany(PelunasanPinjaman::class, 'pinjaman_id');
    }

}
