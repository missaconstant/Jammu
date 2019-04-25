<?php

namespace Jammu\Console;

include __DIR__ . '/../autoload.php';

use Jammu\core\JammuConsoleColorify as Colorizer;

if (strtolower(php_sapi_name()) != 'cli') exit("This is CLI app.");

/**
 * Class that helps to start manually a server
 */
class JammuWatch
{
	/**
	 * Launch watcher
	 * @return { Text Console }
	 */
	public static function watch($argv)
	{
		if (isset($argv[0]))
		{
			if (preg_match("#[0-9]{1,4}.[0-9]{1,4}.[0-9]{1,4}.[0-9]{1,4}[:]{1,4}#", @$argv[0]))
			{
				$address = $argv[0];
				echo "Waiting for device connexion on " . $argv[0] . "\n\n";
				exec("php -S ". @$argv[0]);
			}
			else if (preg_match("#[0-9]{2,4}#", @$argv[0])) {
				echo "Waiting for device connexion on 0.0.0.0:" . $argv[0] . "\n\n";
				exec("php -S 0.0.0.0:" . $argv[0]);
			}
			else {
				exit(Colorizer::colorize("Invalid watch parameters !", "red"));
			}
		}
		else {
			echo "Waiting for device connexion on 0.0.0.0:7071 \n\n";
			exec("php -S 0.0.0.0:7071");
		}
	}
}
