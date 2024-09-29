<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'asets';

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'jumlah_aset',
        'harga_aset',
    ];
}
