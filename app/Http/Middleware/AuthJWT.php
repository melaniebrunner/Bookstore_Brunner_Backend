<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;

class AuthJWT {
    public function handle($request, Closure $next){
        try {
            //Token auf User zurückmatchen (hat ihn schon von server

            if(!$user = JWTAuth::parseToken()->authenticate()){
                return response()->json(['user not found'], 404);
            }
        }
        catch (Exception $e){
            //token ist nicht gültig oder nicht da
            //debuggen: var_dump($request);
            //nicht gültig
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error' => 'invalid token']);
            }
            //expired nach 20Mintuen
            else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error' => 'invalid expired']);
            }
            else {
                return response()->json(['error' => 'authenticaiton error']);
            }
        }
        return $next($request);
    }

}