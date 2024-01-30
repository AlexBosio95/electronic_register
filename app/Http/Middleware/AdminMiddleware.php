<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // TO DO Modificare il Middleware e controllare per prima cosa se il ruolo dell'utente corrente è nel config chiave visibility
        // Visto che per certe rotte alcuni utenti hanno solo accesso alcuni metodi controllare anche questo e restituire 403 nei casi richiesti

        // Controlla se l'utente ha il ruolo 'admin'
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Se l'utente non è autorizzato, genera un errore 403
        abort(403, 'Accesso non autorizzato');
    }
    
}
