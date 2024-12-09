<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    function foodPacks() {
       return $this->hasMany(FoodPack::class);
    }
    function scopeFilter($query, array $filters) {
        $query->where('is_klant', $filters['is_klant'] ?? true);

        if ($filters['search'] ?? null) {
            $query->where(function($q) {
                $q->where('id', request('search'))
                  ->orWhere('gezinsnaam', 'like', '%' .request('search'). '%')
                  ->orWhere('postcode', 'like', '%' .request('search'). '%')
                  ->orWhere('email', 'like', '%' .request('search'). '%')
                  ->orWhere('telefoonnummer', 'like', '%'. request('search'). '%');
            });

        }
    }
}
