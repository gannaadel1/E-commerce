<?php

namespace App\Http\Middleware;

use App\Http\traits\GeneralTrait;
use Closure;

use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
                //throw an exception
            
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
              
                return $this->ReturnError('INVALID _TOKEN','401');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
               
                return $this->ReturnError('EXPIRED_TOKEN','401');
            } else{
                return $this->ReturnError('Error','401');
            }

            if(!$user){
                return $this->ReturnError('unauthinticated','401');
                return $next($request);
            }
        }
      
    }
}
