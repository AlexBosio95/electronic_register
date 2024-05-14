<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /* Logica base per gestire la protezione delle chiamate API con api-key */
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API Key is missing'], 401);
        }

        // Verifica se l'API key è corretta
        if ($apiKey !== 'YOUR_API_KEY') {
            return response()->json(['error' => 'Invalid API Key'], 401);
        }

        return $next($request);
    }
    
}
