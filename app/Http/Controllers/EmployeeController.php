<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return inertia('Auth/WachtwoordVergeten');
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
        //
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
     * Display the form to enter an email address for password reset
     */
    public function checkEmailShow()
    {
        return inertia('Auth/ResetPassword/CheckMail');
    }

    /**
    * Handle the email validation and send an email with code for password reset.
    */
    public function checkEmail(Request $request)
    {
        //valideer email
        $email = $request->input('email');
        session(['email' => $email]);

        //stuur email naar opgegeven email

        //maak een code en zet het in de sessie 
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT); //returned 6 cijferige code tussen 000000 - 999999
        session(['code' => $code]);
        //redirect
        return redirect()->route('resetWachtwoord.checkCode');
    }
    
     /**
     * Display the form for checking the code send to your email
     */
    public function checkCodeShow()
    {
        // Haal de email op uit de sessie en verwijder de sessie
        $email = session('email');
        session()->forget('email');

        //stuur de gebruiker terug als er geen email is
        if(!$email) return redirect()->route('resetWachtwoord.checkEmail');

        //stuur pagina terug
        return inertia('Auth/ResetPassword/CheckCode', ['email' => $email]);
    }

     /**
     * Compares the code sent to the user's email
     */
    public function checkCode(Request $request)
    {
        $code = session('code');
        // dd($code);
        //check de code die is gestuurd of die overeen komt met de gebruikers input code

        //redirect
        return inertia('Auth/ResetPassword/MakeNewPassword');
    }
    
     /**
     * Display the form for creating a new password
     */
    public function createNewPasswordShow()
    {
        return inertia('Auth/ResetPassword/MakeNewPassword');
    }

     /**
     * Update the password from the user
     */
    public function createNewPassword(Request $request)
    {
        //valideer wachtwoorden

        //update de wachtwoorden

        //redirect
        return redirect()->route('inloggen')->with('message', 'Uw wachtwoord is succesvol gereset');
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
    public function destroy(string $id)
    {
        //
    }
}
