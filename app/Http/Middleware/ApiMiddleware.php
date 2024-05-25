<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Login error, missing user'], 401);
        }
        Log::info($request);


        return $next($request);
    }
    
}
