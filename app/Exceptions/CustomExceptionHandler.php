<?php

namespace App\Exceptions;

use App\Config\Message;
use Exception;
use Illuminate\Http\Response;

class CustomExceptionHandler
{
    public static function internalServerError()
    {
        return new Exception(Message::INTERNAL_SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function badRequest()
    {
        return new Exception(Message::BAD_REQUEST, Response::HTTP_BAD_REQUEST);
    }

    public static function forbidden()
    {
        return new Exception(Message::FORBIDDEN, Response::HTTP_FORBIDDEN);
    }

    public static function unauthorized() {
        return new Exception(Message::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
    }
}
