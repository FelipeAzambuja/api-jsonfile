<?php

namespace App\Http\Middleware;

use Closure;

class AuthAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization', false);

        if ($token == false) {
            return response()->json(['message' => 'Metodo negado'], 405);
        }

        $pieces = explode(' ', $token);

        if (config('auth.api_token') != $pieces[1]) {
            return response()->json(['message' => 'Metodo negado'], 405);
        }

        return $next($request);
    }
}
