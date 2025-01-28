<?php

namespace App\Merlin;

use Illuminate\Support\Facades\Storage;

class Import
{
    public function __construct(string $filename, callable $callback)
    {
        $filename = Storage::disk('merlin-csv')->path($filename);
        $handle = fopen($filename, 'r');
        $header = fgetcsv($handle);
        while ($data = fgetcsv($handle)) {
            $row = array_combine($header, $data);
            $callback($row);
        }
        fclose($handle);
    }
}
