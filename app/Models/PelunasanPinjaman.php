<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelunasanPinjaman extends Model
{
    use HasFactory;

    protected $table = 'pelunasan_pinjaman';

    protected $fillable = [
        'user_id',
        'pinjaman_id',
        'jumlah_dibayar',
        'tanggal_bayar',
        'metode_pembayaran',
        'keterangan',
        'status',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pinjaman()
    {
        return $this->belongsTo(PengajuanPinjaman::class, 'pinjaman_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
