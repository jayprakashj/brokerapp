<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( (auth()->user() && auth()->user()->isAppAccessAllowed()) || ( auth('web')->id() ) ){
            return $next($request);

        }
        if( $request->wantsJson() ){

            return response()->json(['message'=>'App access is restricted.'], 403);
        }

        abort( 403 );
    }
}
