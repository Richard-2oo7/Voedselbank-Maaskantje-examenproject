<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request);
        //25 producten per pagina
        $product = Product::query()
            ->with('category')
            ->filter(request(['search', 'category_id']))
            ->paginate(14)
            ->withQueryString();

        $options = Category::select('id', 'naam')->get();

        return inertia('Producten', [
            'producten' => $product,
            'options' => $options,
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
            'EAN' => 'required|string|min:13|max:13|unique:products',
            'aantal' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        //maak nieuw product
        $product = Product::create($validatedProduct);

        //stuur reactie
        return redirect()->back()->with('message', 'Product is succesvol aangemaakt!');
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
            'naam' => 'required|string|max:255|min:1',
            'aantal' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        //zoek het product
        $product = Product::find($id);

        //kijk of het bestaat
        if(!$product) {
            // return response()->json([
            //     'message' => 'Het product bestaat niet!',
            // ], 404);
            return redirect()->back()->with('message', 'Het product bestaat niet.');
        }

        //update het product
        $product->update($validatedProduct);

        //stuur reactie
        return redirect()->back()->with('message', 'Het product is succesvol geupdate');
    }

    public function destroy(Request $request)
    {
        // dd($request);
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
        catch (\Exception $e) {
            //stuur reactie bij fout
            return response()->json([
                'message' => 'Fout in producten verwijderen!',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }
}
