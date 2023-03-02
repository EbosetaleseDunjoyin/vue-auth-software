<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (!Auth::user()->status == 'inactive') {
            auth()->logout();
            return redirect()->response()
                    ->json([
                    'status' => false,
                    'message' => 'unauthorized user'
                ], 401);
          }
   
        return $next($request);
    }
}
