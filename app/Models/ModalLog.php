<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalLog extends Model
{
    use HasFactory;

    protected $fillable = ['tipe', 'jumlah', 'sumber'];

    public static function totalModal()
    {
        $masuk = self::where('tipe', 'masuk')->sum('jumlah');
        $keluar = self::where('tipe', 'keluar')->sum('jumlah');
        return $masuk - $keluar;
    }
}
