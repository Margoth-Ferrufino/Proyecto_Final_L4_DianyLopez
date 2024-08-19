<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class administrador
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->administrador) {
            return $next($request);
        }

        return redirect('/'); // O cualquier otra redirección adecuada
    }
}
