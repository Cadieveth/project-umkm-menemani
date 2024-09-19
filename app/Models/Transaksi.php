<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'produk_sell_id',
        'no_transaksi',
        'harga_barang',
        'qty',
        'sub_total',
    ];

    public function produkSell()
    {
        return $this->belongsTo(ProductSell::class, 'produk_sell_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}