<?php

namespace App\Http\traits;

trait GeneralTrait
{
public function GetCurrentLanguage(){
return app()->getLocale();
}

public function ReturnError($errnum,$msg){
    return response()->json([
        'status'=>false,
        'errnum'=>$errnum,
        'msg'=>$msg,

    ]);
}

public function ReturnSuccess($msg){
    return [
        'status'=>true,
        'errnum'=>null,
        'msg'=>$msg,

    ];
}

public function ReturnData($key,$value,$msg=''){
    return response()->json([
        'status'=>true,
        'errnum'=>200,
        'msg'=>$msg,
        $key=$value,
    ]);
}

public function returnValidationError($code = "E001", $validator)
{
    return $this->ReturnError($code, $validator->errors()->first());
}

public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "name")
            return 'E0011';

        else if ($input == "password")
            return 'E002';
            else if ($input == "email")
            return 'E007';
            else
            return "";
    }


}