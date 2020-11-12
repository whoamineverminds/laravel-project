<?php

namespace App\Helpers;

class Helpers
{
    /**
     * Ограничивает значение $input
     *
     * @param $input
     * @param $checkMin
     * @param $checkMax
     * @param null $setMin
     * @param null $setMax
     */
    public static function clamp(&$input, $checkMin, $checkMax, $setMin = null, $setMax = null)
    {
        if ($input < $checkMin) {
            $input = isset($setMin) ? $setMin : $checkMin;
        } elseif ($input > $checkMax) {
            $input = isset($setMax) ? $setMax : $checkMax;
        }
    }
}
