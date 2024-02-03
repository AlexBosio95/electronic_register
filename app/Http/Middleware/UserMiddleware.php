<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $routeName = $request->route()->getName();
        $segments = explode('.', $routeName);
        $routeName = $segments[0];
        $metodo = $metodo = $request->method();
        $role = $user->role;

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        if (isset(config('sections.'.$routeName.'.visibility')[$role]) && in_array(strtolower($metodo), config('sections.'.$routeName.'.visibility')[$role])){
            return $next($request);
        }
        
        // Se l'utente non è autorizzato, genera un errore 403
        abort(403, 'Accesso non autorizzato');
    }
    
}
