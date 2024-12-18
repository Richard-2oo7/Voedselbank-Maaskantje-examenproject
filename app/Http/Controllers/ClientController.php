<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmRegistrationClient;

use App\Mail\ClientRequestResponse;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $clients = Client::query()->where('is_klant', true)->paginate(15);
        $clients = Client::query()->filter(request(['search']))->paginate(14)->withQueryString();
        
        
        return inertia('Klanten', [
            'clients' => $clients,
        ]);
    }
    
    /**
    * Display a listing of the resource.
    */
    public function indexCLientRequests()
    {
        $clients = Client::query()->filter(request(['search']) + ['is_klant' => false])->paginate(14)->withQueryString();
        
        return inertia('Klantverzoeken', [
            'klantverzoeken' => $clients,
        ]);
    }

    /**
    * Accept new client
    */
    public function responseClientRequest(Request $request)
    {   
        //valideer
        $validatedClientRequest = $request->validate([
            'id' => 'required|exists:clients',
            'keuze' => 'required|string',
        ]);

        //zoek de klant en pak de email
        $client = Client::find($request->input('id'));
        $clientEmail = $client->email;

        //maak de reactie van de medewerker aan
        $medewerkerReactie = [];

        //kijkt of klant word toegevoegt of verwijderd
        if ($validatedClientRequest['keuze'] == 'accepteren') {
            //voeg de klant toe
            $client->update([
                'is_klant' => true,
            ]);
            
            //pas de reactie van de medewerker aan
            $medewerkerReactie = [
                'wordt_klant' => true,
            ];

        } else {
            //validate the request
            $request->validate([
                'redenering' => 'String|max:255'
            ]);

            $medewerkerReactie = [
                'wordt_klant' => false,
                'redenering' => $request->input('redenering'),
            ];
            //verwijder de klant
            $client->delete();
        }         

        //stuur mail met reactie van de medewerker
        Mail::to($clientEmail)->send(
            new ClientRequestResponse($medewerkerReactie)
        );

        return redirect()->back()->with('message', 'Klant verzoek succesvol afgehandeld!');
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

        //als een medewerker een klant toevoegt zorg dat het dat een klant is
        if (!$request->sentMail){
            $validatedClient['is_klant'] = 1;
        } else {
            $validatedClient['is_klant'] = 0;
        }

        //maak nieuwe klant
        Client::create($validatedClient);

        
        //stuur reactie
        //als sentmail true is sturen we een mail
        if($request->sentMail){
            //stuur email daar de klant
            $email = $validatedClient['email'];
            Mail::to($email)->send(
                new ConfirmRegistrationClient()
            );

            return redirect()->route('home')->with('message' , 'U bent succesvol aangemeld als klant. Een medewerker zal er spoedig naar kijken!'); 

        } else {
            return redirect()->back()->with('message' , 'Klant succesvol aangemaakt!');
        }
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
            'email' => 'required|string|max:255|email|' . Rule::unique('clients', 'email')->ignore($id),
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
            return redirect()->back()->with('message', 'De klant bestaat niet!');
        }

        //update de klant
        $client->update($validatedClient);

        //stuur reactie
        return redirect()->back()->with('message', 'Klant succesvol geupdate!');
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(Request $request)
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
            return redirect()->back()->with('message', 'Klant succesvol verwijderd!');
        }
        catch(\Exception $e){
            //stuur reactie
            return redirect()->back()->with('message', 'Fout bij klant verwijderen!');
        }
    }
}
