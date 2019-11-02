<?php

	namespace Jammu\configs;

	include __DIR__ . '/autoload.php';

	/**
	 * Config class
	 */
	class Configs
	{
		/**
		 * Rreturns database configuration values
		 */
		public static function getConfVars()
		{
			return (object) [

				"hostname"  => "localhost:8889",

				"username"  => "root",

				"password"  => "root",

				"database"  => "jammu",

				"dbcharset" => "utf8"
			];
		}
	}
