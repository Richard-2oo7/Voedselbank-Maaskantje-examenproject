<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //25 producten per pagina
        $product = Product::query()->with('category')->paginate(25);

        return inertia('Producten', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //valideer
        $validatedProduct = $request->validate([
            'naam' => 'required|string|max:255',
            'aantal' => 'required|integer|max:10',
            'category_id' => 'required|exists:categories,id',
        ]);

        //maak nieuw product
        $product = Product::create($validatedProduct);

        //stuur reactie
        return response()->json([
            'product' => $product
        ], 200);
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
        //valideer de gegevens
        $validatedProduct =$request->validate([
            'naam' => 'required|string|max:255',
            'aantal' => 'required|integer|max:10',
            'category_id' => 'required|exists:categories,id',
        ]);

        //zoek het product
        $product = Product::find($id);

        //kijk of het bestaat
        if(!$product) {
            return response()->json([
                'message' => 'Het product bestaat niet!',
            ], 404);
        }

        //update het product
        $product->update($validatedProduct);

        //stuur reactie
        return response()->json([
            'message' => 'Product succesvol geupdate!',
            'Product' => $product,
        ], 200);
    }

    public function destroy(Request $request)
    {
        //valideer
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:products,id'
        ]);
        
        try {
            //verwijder het product
            $ids = $request->input('ids');
            Product::whereIn('id', $ids)->delete();
            
            //stuur reactie
            return response()->json([
                'message' => 'Producten succesvol verwijdert!',
            ], 200);
        }
        catch(\Exception $e) {
            //stuur reactie bij fout
            return response()->json([
                'message' => 'Fout in producten verwijderen!',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function IndexCategory () {
        return inertia('productcategorieën');
    }
    
    public function storeProductCategory () {
        
    }
}
