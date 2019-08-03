<?php

namespace Common;

use \PDO;
use \PDOException;

class Database
{
    public $pdo = null;

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
        if (! is_null($this->pdo)) {
            return $this->pdo;
        }

        $this->envData = read_json_file(base_dir() . DS . '.env');
        $db_connection = $this->extractEnvData('db_connection');
        $db_host = $this->extractEnvData('db_host');
        $db_port = $this->extractEnvData('db_port');
        $db_database = $this->extractEnvData('db_database');
        $db_username = $this->extractEnvData('db_username');
        $db_password = $this->extractEnvData('db_password');

        try {
            $pdo = new PDO("$db_connection:host=$db_host;port=$db_port;dbname=$db_database", $db_username, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;

            return $this->pdo;
        } catch (Exception $exception) {
            dd("Unable to connect due to exception: " . $exception->getMessage());
        }
    }

    public function insertExample() 
    {
        $data = array('hey, thats fucked up', '9 Dark and Twisty Road', 'Cardiff');
        $statement = $pdo->prepare("INSERT INTO db_table (name, addr, city) values (?, ?, ?)");

        try {
            $statement->execute();
            $statement->execute($data);
        } catch (\PDOException $err) {
            //
        }
    }

    public function selectExample()
    {
        try {
            $statement = $pdo->query('SELECT name, addr, city from db_table');
        } catch (PDOException $err) {
            echo "Error: ejecutando consulta SQL.";
        }

        $statement = $pdo->prepare('SELECT name, addr, city from db_table where city =:ciudad');
        $data = array(':ciudad' => 'Santiago');

        try {
            $statement->execute($data);
        } catch(PDOException $err) {
           echo "Error: ejecutando consulta SQL.";
        }

        while ($row = $statement->fetch()) {
            echo $row['name'] . "<br/>";
            echo $row['addr'] . "<br/>";
            echo $row['city'] . "<br/>";
        }

        $row = $sql->fetchAll();
        foreach ($data as $row) {
            $id = $row['id'];
            $content = $row['content'];
        }
    }
}