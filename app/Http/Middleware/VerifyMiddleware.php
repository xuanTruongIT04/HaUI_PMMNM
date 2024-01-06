<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomExceptionHandler;
use App\Util\ExceptionHandler;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user == null) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::unauthorized());
        }
        return $next($request);
    }
}
