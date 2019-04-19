<?php
	require_once(__DIR__.'/core/utils.php');

	use Jammu\core\JammuI;

	class helloworld {

		public static function call(StdClass $message)
		{
			JammuI::sendMessage([
				"address" => $message->address,
				"body" => hello()
			]);
		}

	}
