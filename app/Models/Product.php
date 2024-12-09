<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    function category() {
        return $this->belongsTo(Category::class);
    }

    function foodPacks() {
        return $this->belongsToMany(FoodPack::class, 'FoodPackProducts');
    }
    
    function scopeFilter($query, array $filters ) {
        if($filters['search'] ?? false) {
            $query->where(function($q) {
                $q->where('naam', 'like', '%'. request('search') . '%')
                  ->orWhere('EAN', 'like', '%'. request('search') . '%');
            });
        }
        if($filters['category_id'] ?? false) {
            $query->where('category_id',  request('category_id'));
        }

    }
}
