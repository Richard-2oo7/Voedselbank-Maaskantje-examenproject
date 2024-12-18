<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    function scopeFilter($query, array $filters) {
        if ($filters['search'] ?? null) {
            $query->where(function($q) {
                $q->where('bedrijfsnaam', 'like', '%' .request('search'). '%')
                  ->orwhere('naam', 'like', '%' .request('search'). '%')
                  ->orWhere('email', 'like', '%' .request('search'). '%')
                  ->orWhere('locatie', 'like', '%' .request('search'). '%')
                  ->orWhere('email', 'like', '%' .request('search'). '%')
                  ->orWhere('telefoonnummer', 'like', '%' .request('search') .'%');
            });
        }
    }
}
