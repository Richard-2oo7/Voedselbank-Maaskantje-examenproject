<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    function category() {
        $this->belongsTo(Category::class);
    }

    function foodPacks() {
        return $this->belongsToMany(FoodPack::class, 'FoodPackProducts');
    }
}
