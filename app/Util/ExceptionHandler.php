<?php

namespace App\Util;

use Exception;

class ExceptionHandler
{
    public static function CustomHandleException(Exception $exc)
    {
        $response = [
            'status' => strval($exc->getCode()),
            'message' => $exc->getMessage(),
        ];

        return response()->json($response, $exc->getCode());
    }
}
