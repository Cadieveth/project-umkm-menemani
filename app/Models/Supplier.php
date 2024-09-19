<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'alamat',
        'email',
        'kontak',
    ];

    public function stok_masuk()
    {
        return $this->hasMany(StokMasuk::class, 'supplier_id');
    }
}
