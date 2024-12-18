<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Food_pack_product;
use App\Models\FoodPack;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        //roep de seeders aan
        $this->call([
            CategorySeeder::class, //voegt alle categorieën van producten toe
            RoleSeeder::class,     //voegt alle functies toe: directie, magazijnmedewerker, vrijwilliger
        ]);

        Employee::factory(200)->create();
        Supplier::factory(200)->create();
        Client::factory(200)->create();
        Product::factory(200)->create();
        FoodPack::factory(200)->create();
        Food_pack_product::factory(200)->create();

    }
}
