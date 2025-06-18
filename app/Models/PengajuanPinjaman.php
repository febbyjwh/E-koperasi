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
        'tanggal_pengajuan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
