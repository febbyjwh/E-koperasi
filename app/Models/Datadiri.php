<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datadiri extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'foto_ktp',
        'nik',
        'nama_pengguna',
        'tanggal_lahir',
        'jenis_kelamin',
        'email',
        'no_wa',
        'alamat',
        'no_anggota',
        'nip',
        'jabatan',
        'unit_kerja',
        'tanggal_mulai_kerja',
        'status_kepegawaian',
        'tanggal_bergabung',
        'status_keanggotaan',
        'nama_keluarga',
        'hubungan_keluarga',
        'nomor_telepon_keluarga',
        'alamat_keluarga',
        'email_keluarga',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
