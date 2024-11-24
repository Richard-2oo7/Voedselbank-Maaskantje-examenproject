<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'directie',
            'magazijnmedewerker',
            'vrijwilliger',
        ];
        foreach($roles as $role){
            Role::create(['naam' => $role]);
        }
    }
}
