<?php

namespace Common;

use Common\Database;
use \Exception;
use \PDOException;
use \PDO;

class Model
{
    public static $table = '';

    public static $columns = [];

    public static $pdo = null;

    public static function __callStatic(string $title, $params)
    {
        // initialize PDO object
        if (is_null(self::$pdo)) {
            self::$pdo = (new Database())->pdo;
        }

        // check existence of $table property
        if (empty(static::$table)) {
            throw new Exception('Set the static $table property');
        }

        // call the right static method
        if (method_exists(static::class, $title)) {
            return static::$title(... $params);
        }
    }

    protected static function get(array $columns = []) : array
    {
        if (sizeof($columns) === 0) {
            $columns = static::$columns;
        }

        $columns_string = implode(', ', $columns);
        $table = static::$table;

        try {
            $statement = self::$pdo->prepare("SELECT $columns_string FROM $table");
            $statement->execute();
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function store(array $data = []) : bool
    {
        $processed_data = self::processData($data);
        $keys_string = $processed_data['keys_string'];
        $values_string = $processed_data['values_string'];
        $table = static::$table;

        try {
            $statement = self::$pdo->prepare("INSERT INTO $table ($keys_string) VALUES ($values_string)");
            $statement->execute($data);

            return true;
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());

            return false;
        }

        return false;
    }

    protected static function getUpdateString(array $data)
    {
        $processed_data = self::processData($data);
        $array_keys = $processed_data['keys'];
        $array_values = $processed_data['values'];

        $update_string = '';
        $array_length = sizeof($array_keys);

        for ($i = 0; $i < $array_length; $i++) {
            $array_key = $array_keys[$i];

            $update_string .= $array_key . " = '" . $array_values[$i] . "'";

            if ($i !== $array_length - 1) {
                $update_string .= ', ';
            }
        }

        return $update_string;
    }

    protected static function update(int $id, array $data = []) : bool
    {
        $update_string = self::getUpdateString($data);
        $table = static::$table;

        $statement = self::$pdo->prepare("
            UPDATE $table
            SET $update_string
            WHERE id= :id
        ");

        try {
            $statement->execute([
                ':id' => $id
            ]);

            return true;
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());
        }

        return false;
    }

    // TODO: Simplify method
    // TODO: Make the method dynamic, so it can work with multiple tables
    protected static function find(int $id, array $columns = []) : array
    {
        if (sizeof($columns) === 0) {
            $columns = static::$columns;
        }

        $columns_string = implode(', ', $columns);
        $table = static::$table;

        $statement = self::$pdo->prepare("
            SELECT $columns_string 
            FROM $table
            WHERE id = :id
        ");

        try {
            $statement->execute([
                ':id' => $id
            ]);
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());
        }

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    protected static function processData(array $data) : array
    {
        $array_values = array_values($data);
        $array_keys_string = '';
        $array_length = sizeof($data);
        $array_keys = [];

        for ($i = 0; $i < $array_length; $i++) {
            $array_key = array_keys($data)[$i];
            $key_string = str_replace(':', '', $array_key);
            $array_keys[] = $key_string;
            $array_keys_string .= $key_string;

            if ($i !== $array_length - 1) {
                $array_keys_string .= ', ';
            }
        }

        return [
            'keys' => $array_keys,
            'values' => $array_values,
            'keys_string' => $array_keys_string,
            'values_string' => "'" . implode("', '", $array_values) . "'"
        ];
    }

    protected static function destroy(int $id) : bool
    {
        try {
            $table = static::$table;
            $statement = self::$pdo->prepare("DELETE FROM $table WHERE id = :id");
            $statement->execute([
                ':id' => $id
            ]);

            return true;
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());

            return false;
        }

        return false;
    }
}