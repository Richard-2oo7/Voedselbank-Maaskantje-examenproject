<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    function role() {
        return $this->belongsTo(Role::class);
    }

    function scopeFilter($query, array $filters) {
        if ($filters['search'] ?? null) {
            $query->where(function($q) {
                $q->where('naam', 'like', '%' .request('search'). '%')
                  ->orWhere('gebruikersnaam', 'like', '%' .request('search'). '%')
                  ->orWhere('email', 'like', '%' .request('search'). '%')
                  ->orWhere('telefoonnummer', 'like', '%' .request('search') .'%');
            });
        }
    }
}
