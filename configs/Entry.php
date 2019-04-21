<?php

namespace Jammu\configs;

include __DIR__ . '/../autoload.php';

/**
 * Entry class that hold diferents app access
 */
class Entry
{
    /**
     * List diferents entry points
     * @return Array
     */
     public static function getEntries()
     {
         return [
            "helloworld" => "#\#hello#"
         ];
     }
}
