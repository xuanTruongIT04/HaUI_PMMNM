<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomExceptionHandler;
use App\Util\ExceptionHandler;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionAllowMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$listRole): Response
    {
        $user = auth()->user();

        if (!in_array($user->role, $listRole, false)) {
            return ExceptionHandler::CustomHandleException(CustomExceptionHandler::forbidden());
        }

        return $next($request);
    }
}
