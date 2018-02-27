<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessKey
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
        // obtenir api key
        $key = $request->headers->get('api-key');
        // comprovar si coincideix
        if (isset($key) && $key == env('API_KEY')) {
            return $next($request);
        } else {
            // api key wrong
            return response()->json(['error' => 'unauthorized'], 401);
        }
    }
}
