<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin) {
            return $next($request);
        }

        // Rediriger l'utilisateur s'il n'est pas administrateur
        return redirect('/login')->with('error', "Vous n'avez pas accès à cette section.");
    }
}
