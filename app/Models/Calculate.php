<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculate extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'bahan_baku',
        'eoq',
        'rop',
        'safety_stock',
        'frekuensi',
        'frekuensi_konvensional',
        'average_pembelian'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
