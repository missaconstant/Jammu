<?php

namespace Jammu\configs;

include __DIR__ . '/../autoload.php';

/**
 * Entry class that hold diferents app access
 */
class Entry
{
    /**
     * List diferents entry points from entries file
     * @return Array
     */
     public static function getEntries()
     {
         return json_decode( file_get_contents(__DIR__ . '/Entries.json') );
     }
}
