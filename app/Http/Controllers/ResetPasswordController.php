<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ConfirmEmailForPasswordReset;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    
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
        $request->validate([
            'email' => 'required|email|exists:employees'
        ]);

        $email = $request->input('email');
        session(['email' => $email]);

        //stuur email naar opgegeven email

        //maak een code en zet het in de sessie 
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT); //returned 6 cijferige code tussen 000000 - 999999
        session(['code' => $code]);

        Mail::to($email)->send(
            new ConfirmEmailForPasswordReset($code)
        );

        //redirect
        return redirect()->route('resetWachtwoord.checkCode');
    }
    
     /**
     * Display the form for checking the code send to your email
     */
    public function checkCodeShow()
    {
        // Haal de email en code op uit de sessie
        $email = session('email');
        $code = session('code');


        //stuur de gebruiker terug als er geen email of code is
        if(!$email || !$code) return redirect()->route('resetWachtwoord.checkEmail');


        //stuur pagina terug
        return inertia('Auth/ResetPassword/CheckCode', ['email' => $email]);
    }

     /**
     * Compares the code sent to the user's email
     */
    public function checkCode(Request $request)
    {
        //rust anders is er geen feedpack voor de gebruiker
        sleep(1);

        // Haal de code op uit de sessie
        $code = session('code');


        //stuur de gebruiker terug als er geen code is
        if(!$code) return redirect()->route('resetWachtwoord.checkEmail');

        //valideer de code
    // Aangepaste validatie voor de ingevoerde code
        $request->validate([
            'code' => [
                'required',
            ],
        ]);

        //check of code van gebruiker gelijk is aan code in email
        $codeUser = $request->input('code');

        if($code !== $codeUser){
            //stuur gebruiker terug als het fout is
            return redirect()->back()->withErrors([
                'code' => 'De ingevoerde code is onjuist.',
            ]);
        }

       //verwijder de sessie
        session()->forget('code');
 

        //redirect
        return redirect()->route('resetWachtwoord.maakWachtwoord');
    }
    
     /**
     * Display the form for creating a new password
     */
    public function createNewPasswordShow()
    {
        // Haal de email en code op uit de sessie
        $email = session('email');

        //stuur de gebruiker terug als er geen email is
        if(!$email) return redirect()->route('resetWachtwoord.checkEmail');

        return inertia('Auth/ResetPassword/MakeNewPassword');
    }

     /**
     * Update the password from the user
     */
    public function createNewPassword(Request $request)
    {
        $email = session('email');
        //valideer wachtwoorden

        $request->validate([
            'password_confirmation' => 'required|string|min:1',
            'password' => 'required|string|min:1|max:255|confirmed',
        ]);

        //vind de werknemer en pas het wachtwoord aan
        $employer = Employee::where(['email' => $email])->first();

        if(!$employer) {
            return redirect()->route('resetWachtwoord.checkEmail')->withErrors([
                'email' => 'dit account bestaat niet',
            ]);
        }

        $employer->update([
            'password' => bcrypt($request->input('password'))
        ]);

        //verwijder de sessie
        session()->forget('email');

        //redirect
        return redirect()->route('login')->with('message', 'Uw wachtwoord is succesvol gereset');
    }
}
