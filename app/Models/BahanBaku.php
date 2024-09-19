<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_barang',
        'name',
        'satuan',
        'harga',
    ];

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class, 'baku_id');
    }

    public function stokKeluar()
    {
        return $this->hasMany(StokKeluar::class, 'baku_id');
    }

    public function resep()
    {
        return $this->hasMany(Resep::class, 'baku_id');
    }

}
