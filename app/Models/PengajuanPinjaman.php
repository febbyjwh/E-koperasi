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
    'jumlah_diterima', 
    'jumlah_harus_dibayar',
    'total_jasa',
    'cicilan_per_bulan',
    'tanggal_pengajuan',
    'tanggal_dikonfirmasi',
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

    public function angsurans()
    {
        return $this->hasMany(Angsuran::class, 'pinjaman_id');
    }        

}
