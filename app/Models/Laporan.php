<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'no_jurnal',
        'ket',
        'akun_debet',
        'debit',
        'akun_kredit',
        'kredit',
        'akun_hpp',
        'hpp',
        'akun_persediaan',
        'persediaan',
    ];

    public function order()
    {
        return $this->belongsTo(OrderStok::class);
    }
}