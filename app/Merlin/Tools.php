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

    public static function convertDate(string $merlinDate): ?Carbon
    {
        $c = Carbon::createFromFormat('d.m.Y H:i:s', $merlinDate);
        if ($c->year < 1900) return null;
        return $c;
    }
}
