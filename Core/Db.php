<?php

namespace Core;

class Db {
    private static $db;

    private function __construct() {}

    public static function getSettingsPath() {
        $path = ROOT . '/../Config/db_config.php';
        return require_once ($path);
    }

    public static function getConnection() {
        if (!self::$db) {
            $settings = self::getSettingsPath();
            $dsn = "mysql:host={$settings['host']}; dbname={$settings['dbname']}";
            self::$db = new \PDO($dsn, $settings['username'], $settings['password']);
            self::$db->exec("set names utf8");
        } else {
            return self::$db;
        }
        return self::$db;
    }
}

