<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\food_pack_product;
use App\Models\FoodPack;
use Illuminate\Http\Request;

class FoodPackController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodPacks = FoodPack::query()
            ->with('client:id,volwassenen,kinderen,babys')
            ->filter(request(['search']))
            ->select('id', 'client_id', 'uitgiftedatum', 'opgehaald')
            ->whereHas('client', function($query){
                $query->where('is_klant', true);
            })
            ->paginate(15)
            ->withQueryString();

        //stuur gegevens
        return inertia('Voedselpakketten', [
            'voedselpakketten' => $foodPacks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //controleer of de klant bestaat
        $validatedFoodPack = $request->validate([
            'client_id' => 'required|exists:clients,id'
        ]);
        
        //maak het voedselpakket aan
        $foodpack = FoodPack::create($validatedFoodPack);

        //valideer de producten
        $validatedFoodPackProducts = $request->validate([
            'products' => 'required|array',
            'products*.id' => 'required|exists:products,id',
            'products*.aantal.*' => 'required|integer|min:1',
        ]);

        //voeg de producten aan het voedselpakket toe
        foreach($validatedFoodPackProducts['products'] as $product){
            food_pack_product::create([
                'food_pack_id' => $foodpack->id,
                'product_id' => $product->id,
                'aantal_producten' => $product->aantal,
            ]);
        }
        //stuur reactie
        return response()->json([
            'message' => 'voedselpakket succesvol aangemaakt!',
            'foodpack' => $foodpack,
        ], 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
