<?php

namespace Jammu;

header("Access-Control-Allow-Origin: *");
define("ROOT", __DIR__);

include __DIR__ . '/autoload.php';

use Jammu\core\Jammu;
use Jammu\core\JammuI;

/**
 * Jammu Entry point class
 * This is where all starts
 */
class EntryPoint
{
	public static function listen()
	{
		if (isset($_POST['address'])) {
			$js = json_decode(file_get_contents(__DIR__ . '/gateways/messages.json'), true);

			if ( ! JammuI::messageExists($js, $_POST))
			{
				$js[] = $_POST;
				// saving for watcher
				file_put_contents(__DIR__ . '/gateways/messages.json', json_encode($js));
				// fire on message event
				Jammu::onMessage((object) $_POST);
			}
		}

		else if (isset($_GET['get2send'])) {
			// getting messages
			$js = json_decode(file_get_contents(__DIR__ . '/gateways/tosend.json'), true);
			$go = json_encode($js['waiting']);
			// emptying message to send list
			$js['waiting'] = [];
			$js['lastquery'] = date('d/m/Y H:i:s');
			file_put_contents(__DIR__ . '/gateways/tosend.json', json_encode($js));
			// returning messages
			echo $go;
		}

		else if (isset($_GET['searchserver'])) {
			echo json_encode(["error" => false]);
		}

		else {
			if (strtolower(php_sapi_name()) != 'cli') {
				echo json_encode($_POST);
			}
		}
	}
}

EntryPoint::listen();
