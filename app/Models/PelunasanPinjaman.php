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

    protected $casts = [
        'jumlah_dibayar' => 'float',
        'tanggal_bayar' => 'date',
    ];

    /**
     * Relasi ke user yang melakukan pelunasan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke pengajuan pinjaman yang sedang dilunasi
     */
    public function pinjaman()
    {
        return $this->belongsTo(PengajuanPinjaman::class, 'pinjaman_id');
    }

    /**
     * Relasi ke admin yang memverifikasi
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function angsuran()
    {
        return $this->belongsTo(Angsuran::class);
    }


    /**
     * Scope pelunasan yang telah diverifikasi
     */
    public function scopeTerverifikasi($query)
    {
        return $query->where('status', 'terverifikasi');
    }
}
