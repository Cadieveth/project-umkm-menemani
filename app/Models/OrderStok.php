<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStok extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_id',
        'baku_id',
        'no_order',
        'satuan',
        'qty',
        'harga',
        'sub_total',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'ket');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            // Hapus data terkait
            $order->laporan()->delete();
        });
    }
}
