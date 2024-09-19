<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'details';

    protected $fillable = [
        'name',
        'kode',
        'harga',
        'jumlah_stok',
        'satuan',
        'ket',
    ];

    // Jika ada relasi, definisikan di sini (contoh relasi belongsTo atau hasMany)
}
