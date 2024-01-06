<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransactionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Begin transaction
        DB::beginTransaction();
        try {
            $response = $next($request);
        } catch (Exception $ex) {
            DB::rollBack();
        }

        if ($response instanceof Response && $response->getStatusCode() > 399) {
            DB::rollBack();

        } else {
            //Commit transaction
            DB::commit();
        }

        return $response;
    }
}
