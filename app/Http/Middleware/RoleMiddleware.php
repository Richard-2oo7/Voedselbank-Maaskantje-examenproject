<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // De rolparameter die we via de route meegeven
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next, string $allowedRoles = null): Response
    {
        // Verkrijg de ingelogde gebruiker
        $user = Auth::user();

        //maak array van alle mogelijke rollen die de pagina mogen bezoeken
       $AllowedRolesArr = explode('/', $allowedRoles);
       array_push($AllowedRolesArr, 'directie');
       
        // Als er geen gebruiker is of als de rol niet overeenkomt, gooi dan een fout
        if (!$user ||  !in_array($user->role->naam, $AllowedRolesArr)) {
            abort(403, 'Geen toegang');
        }

        return $next($request);
    }
}
