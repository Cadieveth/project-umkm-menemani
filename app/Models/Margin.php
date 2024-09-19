<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    use HasFactory;

    protected $table = 'margin';

    protected $fillable = [
        'margin',
    ];

    // Jika ada relasi, definisikan di sini (contoh relasi belongsTo atau hasMany)
}
