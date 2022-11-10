<?php

namespace Wovosoft\BkbOffices\Converters;

use Illuminate\Support\Collection;

class CsvToCollection
{
    public static function convert(string $path): Collection
    {
        $file_to_read = fopen($path, 'r');
        $lines = [];
        while (!feof($file_to_read)) {
            $lines[] = fgetcsv($file_to_read, 1000, ',');
        }

        fclose($file_to_read);
        $rows = collect();
        $header = $lines[0];
        for ($x = 1; $x < count($lines) - 1; $x++) {
            $row = new \stdClass();
            foreach ($header as $k => $h) {
                $row->{str($h)->lower()} = $lines[$x][$k];
            }
            $rows->add($row);
        }
        return $rows;
    }
}
