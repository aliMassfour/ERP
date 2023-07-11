<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)->header('Access-Control-Allow-Origin', '*') //this header to allow the * (all) domain to access our api
            ->header('Access-Control-Allow-Methods', 'GET,POST,DELETE,PUT,PATCH') //determine the Http methode that the domain can do
            ->header('Access-Control-Allow-Header', 'content-type,Authorization');
        //contetnt-type should be in the header request with valu application/json
        //Authorization content the token that we have after login or register and it should be "Bearer Token"
    }
}
