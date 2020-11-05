<?php

namespace App\Helpers;

use App\Exceptions\IncorrectNameException;
use Illuminate\Http\Request;

class Helpers
{
    public static function getRequiredHttpParam(Request $request, $param)
    {
        $result = $request->get($param);
        if (empty($result)) {
            throw new IncorrectNameException(sprintf('Parameter %s is absent', $param));
        }

        return $result;
    }

    public static function clamp(&$input, $checkMin, $checkMax, $setMin = null, $setMax = null)
    {
        if ($input < $checkMin) {
            $input = isset($setMin) ? $setMin : $checkMin;
        } elseif ($input > $checkMax) {
            $input = isset($setMax) ? $setMax : $checkMax;
        }
    }
}
