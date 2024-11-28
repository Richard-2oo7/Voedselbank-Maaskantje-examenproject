<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPack extends Model
{
    /** @use HasFactory<\Database\Factories\FoodPackFactory> */
    use HasFactory;

    function client() {
        return $this->belongsTo(Client::class);
    }

    function products() {
        return $this->belongsToMany(Product::class, 'FoodPackProducts');
    }
}
