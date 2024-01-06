<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConvertResponseFieldsToCamelCase
{
    public const CASE_SNAKE = 'snake';

    public const CASE_CAMEL = 'camel';

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof JsonResponse) {
            $response->setData(
                $this->convertKeysToCase(
                    self::CASE_CAMEL,
                    json_decode($response->getContent(), true)
                )
            );
        }

        return $response;
    }

    public function convertKeysToCase(string $case, $data)
    {
        if (! is_array($data)) {
            return $data;
        }

        $array = [];

        foreach ($data as $key => $value) {
            $array[Str::{$case}($key)] = is_array($value)
                ? $this->convertKeysToCase($case, $value)
                : $value;
        }

        return $array;

    }
}
