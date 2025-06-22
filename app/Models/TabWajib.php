<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabWajib extends Model
{
    use HasFactory;
    protected $table = 'tabungan_wajib';

    protected $fillable = [
        'user_id',
        'jenis',
        'nominal',
        'total',
        'tanggal',
    ];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
