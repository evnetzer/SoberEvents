<?php

	class DB {
		private static $db_hostname = "localhost";
		private static $db_database = "SoberFriend";
		private static $db_username = "developer1";
		private static $db_password = "password";
		private static $db = NULL;

		public static function Prepare($sql) {
			if (!self::$db) {
				self::Setup();
			}
			return self::$db->prepare($sql);
		}

		public static function LastInsertId() {
			if (!self::$db) {
				self::Setup();
			}
			return self::$db->lastInsertId();
		}

		private static function Setup() {
			if (!self::$db) {
				self::$db = new PDO('mysql:host=' . self::$db_hostname . ';dbname=' . self::$db_database, self::$db_username, self::$db_password);
				self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
		}
	}