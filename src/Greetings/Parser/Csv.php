<?php

namespace Greetings\Parser;

class Csv
{
    public static function parse($filename)
    {
        $result = array();
        if (is_readable($filename)
            && ($handle = fopen($filename, "r")) !== false) {
            $keys = fgetcsv($handle, null, ";");
            while (($values = fgetcsv($handle, null, ";")) !== false) {
                $result[] = array_combine($keys, $values);
            }
            fclose($handle);
        }

        return $result;
    }
} 