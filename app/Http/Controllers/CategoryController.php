<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorieën = Category::query()->paginate(15);
        
        return inertia('productcategorieën', [
            'productCategorieën' => $categorieën,
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
        $validatedCategory = $request->validate([
            'naam' => 'required|min:1|string',
        ]);

        Category::create($validatedCategory);

        return redirect()->back()->with('message', 'Categorie succesvol aangemaakt!');
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
        //valideer
        $validatedCategory = $request->validate([
            'id' => 'required|exists:categories',
            'naam' => 'required|min:1|string',
        ]);

        $category = Category::find($id);

        $category->update([
            'naam' => $validatedCategory['naam'],
        ]);

        return redirect()->back()->with('message', 'Categorie succesvol geupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //valideer
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:categories,id',
        ]);

        //bekijk of de categorieën gekoppeld zijn aan producten
        foreach($request->input('ids') as $id){
            $category = Category::find($id);
            if($category && $category->products()->exists()){
                return redirect()->back()->with('message', 'Kan Categorie niet verwijderen, omdat het gekoppeld is aan verschillende producten!');
            }
        }

        try{
            //verwijder alle medewerkers
            $ids = $request->input('ids');

            Category::whereIn('id', $ids)->delete();
            
            //stuur reactie
            return redirect()->back()->with('message', 'Categorie succesvol verwijderd!');
        }
        catch(\Exception $e){
            //stuur reactie
            return redirect()->back()->with('message', 'Fout bij Categorie verwijderen!');
        }
    }
}
