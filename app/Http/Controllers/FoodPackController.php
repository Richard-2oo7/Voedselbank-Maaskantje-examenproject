<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\food_pack_product;
use App\Models\FoodPack;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodPackController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Maandag van deze week
        $endOfWeek = Carbon::now()->endOfWeek(); // Zondag van deze week

        $foodPacks = FoodPack::query()
            ->with('client:id,volwassenen,kinderen,babys')
            ->filter(request(['search']))
            ->with('client')
            ->with('products')
            ->whereHas('client', function($query){
                $query->where('is_klant', true);
            })
            ->paginate(14, ['*'], 'foodpack_page')
            ->withQueryString();

        $clients = Client::query()
            ->with('foodpacks')
            ->whereDoesntHave('foodpacks', function($query) use ($startOfWeek, $endOfWeek) {
                // Check of het laatste voedselpakket voor de klant gemaakt is in deze week
                $query->whereBetween('datum_samenstelling', [$startOfWeek, $endOfWeek]);
            })
            ->paginate(14, ['*'], 'client_page')
            ->withQueryString();



        $producten = Product::query()->where('aantal', '>' ,0)->paginate(10, ['*'], 'product_page')->withQueryString();

        $client = Client::find($request->input('client_id'));

        //stuur gegevens
        return inertia('Voedselpakketten', [
            'voedselpakketten' => $foodPacks,
            'klanten' => $clients,
            'producten' => $producten,
            'geselecteerdeKlant' => $client,
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
        
        //valideer de producten
        $validatedFoodPackProducts = $request->validate([
            'products' => 'required|array',
            'products.*id' => 'required|exists:products,id',
            'products.*aantal.*' => 'required|integer|min:1',
        ]);
        
        //maak het voedselpakket aan
        $foodpack = FoodPack::create($validatedFoodPack);

        //voeg de producten aan het voedselpakket toe
        foreach($validatedFoodPackProducts['products'] as $product){
            food_pack_product::create([
                'food_pack_id' => $foodpack->id,
                'product_id' => $product['id'],
                'aantal_producten' => $product['aantal'],
            ]);
            $editedProduct = Product::find($product['id']);
            $editedProduct->update([
                'aantal' => $editedProduct->aantal - $product['aantal'],
            ]);
        }
        //stuur reactie
        return redirect()->back()->with('message', 'voedselpakket succesvol aangemaakt!');
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
        $request->validate([
            'opgehaald' => 'required|boolean',
        ]);

        //zoek het voedselpakket
        $voedselpakket = FoodPack::findOrFail($id);

        $voedselpakket->update([
            'opgehaald' => 1,
            'uitgiftedatum' => now()
        ]);

        return redirect()->back()->with('message', 'voedselpakket geupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
