<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items_details()
    {
        return $this->hasMany(Item_detail::class);
    }

    public function items_results()
    {
        return $this->hasMany(items_results::class);
    }
}
