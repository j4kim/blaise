<?php

namespace App\Merlin;

use Carbon\Carbon;

class Tools
{
    public static function convertTimestamp(?string $merlinTimestamp): ?Carbon
    {
        if (!$merlinTimestamp || $merlinTimestamp === '0') return null;
        $x = intval($merlinTimestamp);
        $ts = intval(6.3115e8 + 0.86402 * $x);
        return new Carbon($ts);
    }
}
