<?php

namespace Common;

use \PDO;

class Database
{
    protected static $connection = null;

    protected $envData;

    public function __construct()
    {
        $this->createConnection();
    }

    public function extractEnvData(string $name, $default_value = '')
    {
        return isset($this->envData[$name]) ? $this->envData[$name] : $default_value;
    }

    public function createConnection()
    {
        if (! is_null(self::$connection)) {
            return self::$connection;
        }

        $this->envData = read_json_file(base_dir() . DS . '.env');
        $db_connection = $this->extractEnvData('db_connection');
        $db_host = $this->extractEnvData('db_host');
        $db_port = $this->extractEnvData('db_port');
        $db_database = $this->extractEnvData('db_database');
        $db_username = $this->extractEnvData('db_username');
        $db_password = $this->extractEnvData('db_password');

        try {
            $connection = new PDO("$db_connection:host=$db_host;port=$db_port;dbname=$db_database", $db_username, $db_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection = $connection;

            return self::$connection;
        } catch (Exception $exception) {
            dd("Unable to connect: " . $exception->getMessage());
        }
    }
}