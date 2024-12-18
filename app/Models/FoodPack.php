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

public function products()
{
    return $this->belongsToMany(Product::class, 'food_pack_products')
                ->withPivot('food_pack_id', 'product_id', 'aantal_producten');

}

    function scopeFilter($query, array $filters) {
        
        if($filters['search'] ?? null) {
            $query->where(function($q) {
                $q->where('id', request('search'))
                ->orWhere('client_id', request('search'));
            });
        }
        $query->latest();
    }
}
