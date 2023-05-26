<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAut::parseToken()->authenticate();
          } catch (Exception $e) {
               if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
             return response()->json(['status' => 'Token is Invalid'], 403);
           }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
             return response()->json(['status' => 'Token is Expired'], 401);
           }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
             return response()->json(['status' => 'Token is Blacklisted'], 400);
           }else{
                 return response()->json(['status' => 'Authorization Token not found'], 404);
           }
        }
    }
}