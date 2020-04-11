<?php

namespace PitouFW\Core;

use Exception;
use PDO;

abstract class DB {
	private static
	$admin_instance = null;
	
	public static function getAdmin(): PDO {
		if (self::$admin_instance == null) {
			try	{
				self::$admin_instance = new PDO('mysql:host=' . DB_ADMIN_HOST . ';dbname=' . DB_ADMIN_NAME, DB_ADMIN_USER, DB_ADMIN_PASS);
				self::$admin_instance->exec("SET CHARACTER SET utf8");
			}
			catch (Exception $e) {
				die('Erreur : ' . $e->getMessage());
			}
		}
		
		return self::$admin_instance;
	}

    public static function getCore(): PDO {
        if (self::$admin_instance == null) {
            try	{
                self::$admin_instance = new PDO('mysql:host=' . DB_CORE_HOST . ';dbname=' . DB_CORE_NAME, DB_CORE_USER, DB_CORE_PASS);
                self::$admin_instance->exec("SET CHARACTER SET utf8");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        return self::$admin_instance;
    }

    public static function getConsole(): PDO {
        if (self::$admin_instance == null) {
            try	{
                self::$admin_instance = new PDO('mysql:host=' . DB_CONSOLE_HOST . ';dbname=' . DB_CONSOLE_NAME, DB_CONSOLE_USER, DB_CONSOLE_PASS);
                self::$admin_instance->exec("SET CHARACTER SET utf8");
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        return self::$admin_instance;
    }
}