<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jumlah',
        'keterangan',
        'sumber',
        'status',
        'user_id',
    ];

    protected $casts = [
    'tanggal' => 'datetime',
    ];

    // Relasi dengan User (jika ada)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
