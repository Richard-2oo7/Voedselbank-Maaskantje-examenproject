<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::query()->filter(request(['search']))->paginate(14)->withQueryString();

        return inertia('Leveranciers', [
            'leveranciers' => $suppliers
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
        $validatedSupplier = $request->validate([
            'bedrijfsnaam' => 'required|string|max:255',
            'naam' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:employees',
            'telefoonnummer' => 'required|string|max:255',
            'adres' => 'required|String|max:255',
            'volgende_levering' => 'nullable|date',

        ]);

        //maak nieuwe klant
        Supplier::create($validatedSupplier);

        return redirect()->back()->with('message' , 'Leverancier succesvol aangemaakt!');
                
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
        $validatedEmployee = $request->validate([
            'id' => 'exists:suppliers',
            'bedrijfsnaam' => 'required|string|max:255',
            'naam' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:employees',
            'telefoonnummer' => 'required|string|max:255',
            'adres' => 'required|String|max:255',
            'volgende_levering' => 'nullable|date',
        ]);

        //zoek de werknemer
        $employee = Supplier::find($id);
        
        //update de werknemer
        $employee->update($validatedEmployee);

        return redirect()->back()->with('message' , 'Leverancier succesvol geupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:suppliers,id',
        ]);

        try{
            //verwijder alle medewerkers
            $ids = $request->input('ids');
            Supplier::whereIn('id', $ids)->delete();

            //stuur reactie
            return redirect()->back()->with('message', 'Leverancier succesvol verwijderd!');
        }
        catch(\Exception $e){
            //stuur reactie
            return redirect()->back()->with('message', 'Fout bij Leverancier verwijderen!');
        }
    }
}
