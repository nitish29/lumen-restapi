<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //

	public function success($data, $code) {
        
        return response()->json(['users' => $data], $code);

    }
    
    public function error($message, $code) {
        
        return response()->json(['error_message' => $message], $code);

    }


}
