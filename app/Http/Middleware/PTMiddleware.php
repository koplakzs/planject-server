<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth()->check() &&  Auth()->user()->role === "pt") {

            return $next($request);
        }
        return response()->json([
            "status" => "fail",
            "statusCode" => 403,
            "message" => "Forbidden Access"
        ], 403);
    }
}
