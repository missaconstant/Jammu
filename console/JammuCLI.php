<?php

namespace Jammu\console;

include __DIR__ . '/../autoload.php';

use Jammu\core\JammuI;
use Jammu\core\JammuConsoleColorify as Colorizer;

if (strtolower(php_sapi_name()) != 'cli') exit("This is CLI app.");

/**
 * Console app to create new Jammu app easily
 */
class JammuCLI
{
    /**
     * Method for applicatoin creation
     * @param argv { Array }
     */
    public static function create($argv)
    {
        $appname = @$argv[0];
        $entry   = @$argv[1];
        $spaces  = "    ";
        $appdir  = __DIR__ . '/../apps/' . $appname;

        // exit(addslashes($entry));

        echo "\n" . Colorizer::colorize("--- Jammu start creating app [ $appname ] ---") . "\n";

        // Some verifications
        if ( ! @mkdir($appdir) ) {
            if ( ! isset($argv[0]) || ! strlen(trim($argv[0])))
            {
                exit(Colorizer::colorize($spaces . "You have to provide app name !\n", "red"));
            }
            else if ( file_exists($appdir) )
            {
                exit(Colorizer::colorize($spaces . "App [ $appname ] already exists !\n", "red"));
            }
            else {
                exit(Colorizer::colorize($spaces . "Failed creating app folder in apps. May be permission denied !\n", "red"));
            }
        }

        // start creation process
        self::createProcess($appname, $appdir, $entry);

        echo Colorizer::colorize($spaces . "App [ $appname ] successfully created !", "green") . "\n";

        echo "\n";
    }

    /**
     * Method for applicatoin removeing
     * @param argv { Array }
     */
    public static function delete($argv)
    {
        $appname = $argv[0];
        $spaces  = "    ";

        echo "\n" . Colorizer::colorize("--- Jammu start deleting app [ $appname ] ---") . "\n";
        echo Colorizer::colorize("ARE YOU SURE TO DO THIS ? (YES / no)", "yellow") . " : ";

        $line = readline();

        if ($line != 'YES') exit(Colorizer::colorize("Operation canceled ! \n", "blue"));

        if ( ! self::removeDir(__DIR__ . '/../apps/' . $appname) )
        {
            exit(Colorizer::colorize($spaces . "Failed deleting app[ $appname ]. May be permission denied or app not exists !\n\n", "red"));
        }

        echo Colorizer::colorize($spaces . "App [ $appname ] successfully deleted !", "green") . "\n";

        echo "\n";
    }

    private static function createProcess($appname, $appdir, $entry=false)
    {
        // app.php file creation process

        $file_content = "<?php\n\n" .
                        "use Jammu\\core\\JammuI;\n\n" .
                        "class $appname {\n\n" .
                        "\tpublic static function call(StdClass \$message)\n" .
                        "\t{\n" .
                        "\t\tJammuI::sendMessage([\n" .
                        "\t\t\t\"address\" => \$message->address,\n" .
                        "\t\t\t\"body\"    => \"Hello you are on my Jammu app [ $appname ]\"\n" .
                        "\t\t]);\n" .
                        "\t}\n" .
                        "\n}";

        if ( ! file_put_contents($appdir . '/app.php', $file_content) )
        {
            exit(Colorizer::colorize($spaces . "An error occured ! Please check permissions.\n", "red"));
        }

        // adding entry point to Entries file

        if ( $entry && strlen(trim($entry)) )
        {
            $newlines = [];
            $entries  = json_decode(file_get_contents(__DIR__ . '/../configs/Entries.json'), true);
            $entries[] = $appname . ': ' . $entry;

            foreach ($entries as $app => $line)
            {
                $newlines[] = "\t\"$line\"";
            }

            $newlines = "[\n" .
                        implode(",\n", $newlines) .
                        "\n]";

            file_put_contents(__DIR__ . '/../configs/Entries.json', $newlines);
        }
    }

    private static function removeDir($dir) {
       $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
          (is_dir("$dir/$file")) ? self::removeDir("$dir/$file") : @unlink("$dir/$file");
        }
        return @rmdir($dir);
    }
}
