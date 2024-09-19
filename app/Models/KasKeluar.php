<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KasKeluar extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'created_at',
        'akun',
        'nominal',
        'keterangan',
    ];
}
