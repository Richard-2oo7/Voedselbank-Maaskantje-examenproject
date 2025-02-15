<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Auth/Inloggen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedCredentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt([
            'email' => $validatedCredentials['email'],
            'password' => $validatedCredentials['password'],
        ])) {
            $userRole = Auth::user()->role->naam;
            $route = null;
            switch($userRole){
                case 'directie':
                    $route = 'klanten';
                    break;
                case 'magazijnmedewerker':
                    $route = 'producten';
                    break;
                case 'vrijwilliger':
                    $route = "voedselpakketten";
                    break;
            }
            request()->session()->regenerate();
            return redirect()->route($route);
        } else{
            //stuur fout
            throw ValidationException::withMessages([
                'email' => "Invalid credentials",
            ]);
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
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
