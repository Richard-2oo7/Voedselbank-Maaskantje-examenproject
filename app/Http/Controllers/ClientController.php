<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmRegistrationClient;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::query()->where('is_klant', true)->paginate(15);
        
        return inertia('Klanten', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Aanmelden');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //valideer
        $validatedClient = $request->validate([
            'postcode' => 'required|string|max:255 ',
            'gezinsnaam' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:clients',
            'telefoonnummer' => 'required|string|max:10',
            'allergisch' => 'nullable|string|max:255',
            'veganistisch' => 'required|boolean',
            'vegetarisch' => 'required|boolean',
            'varkensvlees' => 'required|boolean',
            'volwassenen' => 'required|integer|min:1',
            'kinderen' => 'required|integer|min:0',
            'babys' => 'required|integer|min:0',
        ]);
        // dd($request);
            //maak nieuwe klant
            Client::create($validatedClient);

            //stuur email daar de klant
            $email = $validatedClient['email'];
            Mail::to($email)->send(
                new ConfirmRegistrationClient()
            );
            
            //stuur reactie
            return redirect()->route('home')->with(
                'message' , 'U bent succesvol aangemeld als klant. Een medewerker zal er spoedig naar kijken!'
            );  
    }
    //maakt een sessie
    public function createSession(){
        return redirect()->route('klanten');
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
        $validatedClient = $request->validate([
            'postcode' => 'required|string|max:255',
            'gezinsnaam' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:clients,email',
            'telefoonnummer' => 'required|string|max:255',
            'veganistisch' => 'required|boolean',
            'vegetarisch' => 'required|boolean',
            'varkensvlees' => 'required|boolean',
            'allergisch' => 'nullable|string',
            'volwassenen' => 'required|integer|min:0',
            'kinderen' => 'required|integer|min:0',
            'babys' => 'required|integer|min:0',
        ]);

        //zoek de klant
        $client = Client::find($id);

        //als de klant niet bestaat
        if(!$client){
            //stuur reactie
            return response()->json([
                'message' => 'klant bestaat niet!'
            ], 404);
        }

        //update de klant
        $client->update($validatedClient);

        //stuur reactie
        return response()->json([
            'message' => 'Klant succesvol geupdate!',
            'client' => $client,
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMultiple(Request $request)
    {
        //valideer
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:clients,id',
        ]);

        try{
            //verwijder alle klanten
            $ids = $request->input('ids');
            Client::whereIn('id', $ids)->delete();

            //stuur reactie
            return response()->json([
                'message' => 'Producten succesvol verwijdert!',
            ]);
        }
        catch(\Exception $e){
            //stuur reactie
            return response()->json([
                'message' => 'Fout bij producten verwijderen!',
            ], 500);
        }
    }
}
