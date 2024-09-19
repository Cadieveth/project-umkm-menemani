<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSell extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'no_resep',
        'kode_product',
        'nama_product',
        'hpp',
        'bb_keluar',
        'overhead',
        'qty_in',
        'qty_out',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'produk_sell_id');
    }
}
