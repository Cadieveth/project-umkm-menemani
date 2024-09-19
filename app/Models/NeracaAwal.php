<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeracaAwal extends Model
{
    use HasFactory;

    protected $table = 'neraca_awals';

    protected $fillable = [
        'akun_debet',
        'debit',
        'akun_kredit',
        'kredit',
    ];

    // Jika ada relasi, definisikan di sini (contoh relasi belongsTo atau hasMany)
}
