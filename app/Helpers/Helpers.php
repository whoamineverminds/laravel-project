<?php

namespace App\Helpers;

class Helpers
{
    public static function clamp(&$input, $checkMin, $checkMax, $setMin = null, $setMax = null)
    {
        if ($input < $checkMin) {
            $input = isset($setMin) ? $setMin : $checkMin;
        } elseif ($input > $checkMax) {
            $input = isset($setMax) ? $setMax : $checkMax;
        }
    }
}
