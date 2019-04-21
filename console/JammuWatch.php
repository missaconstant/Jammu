<?php

namespace Jammu\Console;

include __DIR__ . '/../autoload.php';

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
		if (!isset($argv[0])) exit();

		if (preg_match("#[0-9]{1,4}.[0-9]{1,4}.[0-9]{1,4}.[0-9]{1,4}[:]{1,4}#", @$argv[0]))
		{
			$address = $argv[0];
			echo "Attente de connexion du device au " . $argv[0] . "\n\n";
			exec("php -S ". @$argv[0]);
		}
		else if (preg_match("#[0-9]{2,4}#", @$argv[0])) {
			echo "Attente de connexion du device au 0.0.0.0:" . $argv[0] . "\n\n";
			exec("php -S 0.0.0.0:" . $argv[0]);
		}
		else
		{
			echo "Erreur !\nFaites ./jammu-watch adresse_ip_sur_le_reseau:port_choisi\nExemple: 192.168.1.5:3000\n\n";
		}
	}
}
