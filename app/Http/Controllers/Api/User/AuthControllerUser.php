<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerUser extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
    {

        try {
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('user_api')->attempt($credentials);

            if (!$token)
                return $this->ReturnError('401', 'wrong credentials');

                $user=Auth::guard('user_api')->user();
                $user->api_token=$token;
                return $this->ReturnData('user',$user,'done');



        }
        catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
    }


}

public function logout(Request $request){
    $token=$request->header('auth-token');
    if($token){
        try{
        JWTAuth::setToken($token)->invalidate();
        return $this->ReturnSuccess('you are now logged out');
        }catch( TokenInvalidException $e){
return $this->ReturnError('403','something went wrong');
        }
    }
    else{
        return $this->ReturnError('401','something went wrong');

    }
}
}
