<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDefaultCompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $defaultCompany = \Helper::retrieveDefaultCompany();
        if( !is_null( $defaultCompany ) ){
            return $next($request);
        }

        session()->flash('error-message', 'Err! You must have one active default company from your companies.');
        return redirect()->route('company.index');
    }
}
