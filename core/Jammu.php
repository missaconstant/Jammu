<?php

namespace Jammu\core;

include __DIR__ . '/../autoload.php';

use Jammu\core\JammuI;
use Jammu\configs\Entry;

/**
 * Jammu Class that handle message incomming
 */
 class Jammu
 {
     static function hello()
     {
         echo str_replace('Jammu', "Hello from Jammu", 'Ivory Coast');
     }

     /**
     * Use this method to do regular actions
     * Event fired on new message incoming
     * Here you can call your apps with JammuI::app() Method
     * @param StdClass message
     * @return Void
     */
     public static function onMessage ($message)
     {
         # You can directly code your app here or
         # Do it in the /apps folder and then import it here using
         # JammuI::app(String appname, StdClass message, Boolean pass)

         self::loadApps($message);
     }

     /**
      * Method tha call apps defined in Entry class
      * @param message { stdClass }
      * @return Void
      */
     public static function loadApps($message)
     {
         $entries = Entry::getEntries();

         // looping on entries to execute thoes defined
         foreach ($entries as $appname => $pregEntry) {
             JammuI::app($appname, $message, preg_match($pregEntry, $message->body));
         }
     }
 }
