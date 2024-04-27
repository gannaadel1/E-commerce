<?php

namespace App\Http\Middleware;

use App\Http\traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AssignGuard extends BaseMiddleware
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard=null): Response
    {
        if($guard!=null)
        auth()->shouldUse($guard);
      $token=$request->header('auth-token');
      $request->headers->set('auth-token',(string)$token,true);//b7ot 3aleeh constraint yb2a fe token mb3oot
      $request->headers->set('authorization','Bearer'.$token,true);//b7ot 3aleeh constraint yb2a fe authorization mb3oot
      try{
        // $user=$this->auth->authenticate($request);
        $user=JWTAuth::parseToken()->authenticate();
      }catch(TokenExpiredException $e){
        return $this->ReturnError('401','something went wrong');
      }
      catch(JWTException $e){
        return $this->ReturnError('401','something went wrong',$e->getMessage());
      }


        return $next($request);
    }
}
