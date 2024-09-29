<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        // 'produk_id',
        'baku_id',
        'supplier_id',
        'invoice',
        'stok_masuk',
        'keterangan',
    ];

    public function baku()
    {
        return $this->belongsTo(BahanBaku::class, 'baku_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

}
