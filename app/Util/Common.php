<?php

namespace App\Util;

use Illuminate\Support\Str;

class Common
{
    public static function convertKeysToCase(string $case, $data)
    {
        if (! is_array($data)) {
            return $data;
        }

        $array = [];

        foreach ($data as $key => $value) {
            $array[Str::{$case}($key)] = is_array($value)
                ? Common::convertKeysToCase($case, $value)
                : $value;
        }

        return $array;

    }
}
