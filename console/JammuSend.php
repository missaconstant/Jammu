<?php

namespace Jammu\console;

include __DIR__ . '/../autoload.php';

use Jammu\core\JammuI;

if (strtolower(php_sapi_name()) != 'cli') exit("This is CLI app.");

/**
 * JammuSend Class help to send SMS from command line
 */
class JammuSend
{
	/**
	 * Action method checks and send SMS to specified number(s)
	 * @return void { Text console };
	 */
	public static function send($argv)
	{
		// sending message process
		if (strtolower(php_sapi_name()) == 'cli')
		{
			if (count($argv))
			{
				if (isset($argv[1]) && isset($argv[2]))
				{
					// formating message
					$message = (object) ["address" => self::checkNumbers($argv[1]), "body" => $argv[2]];
					// sending message
					JammuI::sendMessage($message);
				}
				else {
					echo "\nParamètres pas complets !\n\n";
				}
			}
			else {
				echo "no args !";
			}
		}
	}

	/**
	 * checkNumbers Checks number source
	 * @param numberSource String { path }
	 * @return Array
	 * @return String
	 */
	public static function checkNumbers($numberSource)
	{
		$value = $numberSource;

		if (preg_match("#path:#", $numberSource)) {
			$source = explode(':', $numberSource);
			if (file_exists(trim($source[1]))) {
				$numbers = explode("\n", file_get_contents($source[1]));
				return implode(',', $numbers);
			}
		}

		return $value;
	}
}
