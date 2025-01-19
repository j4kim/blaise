<?php

namespace App\Merlin;

class Tools
{
    public static function convertTimestamp(int|string|null $merlinTimestamp): string
    {
        if (!$merlinTimestamp) return "";
        $x = intval($merlinTimestamp);
        $ts = intval(6.3115e8 + 0.86402 * $x);
        return date("d.m.Y H:i", $ts);
    }
}