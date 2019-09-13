<?php

namespace Common;

use Common\Database;
use \Exception;
use \PDOException;
use \PDO;

// TODO: Generate slug automatically by title
// TODO: Add has_slug static property and generate it automatically given another field
// TODO: Implement destroyed_at datetime column
// TODO: Implement created_at datetime column
// TODO: Mark and handle boolean fields
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

    protected static function paginate(int $no_rows = 15, int $start = 0, array $columns = []) : array
    {
        if (sizeof($columns) === 0) {
            $columns = static::$columns;
        }

        $columns_string = implode(', ', $columns);
        $table = static::$table;

        try {
            $statement = self::$pdo->prepare("
                SELECT $columns_string, (SELECT COUNT(*) FROM $table LIMIT 1) as total_rows
                FROM $table
                LIMIT $start, $no_rows
            ");

            $statement->execute();
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($rows as &$row) {
            $row['pagination_rows'] = $no_rows;
        }

        return $rows;
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
    protected static function find($identifier, array $columns = []) : array
    {
        if (sizeof($columns) === 0) {
            $columns = static::$columns;
        }

        $columns_string = implode(', ', $columns);
        $table = static::$table;

        // retrieve the row using the slug string
        $statement = self::$pdo->prepare("
            SELECT $columns_string
            FROM $table
            WHERE slug = :slug
        ");
        $data = [ ':slug' => $identifier ];

        if (is_numeric($identifier)) {
            // retrieve the row using the id integer
            $statement = self::$pdo->prepare("
                SELECT $columns_string
                FROM $table
                WHERE id = :id
            ");
            $data = [ ':id' => $identifier ];
        }

        try {
            $statement->execute($data);
        } catch (PDOException $exception) {
            dd('Exception message: ' . $exception->getMessage());
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return is_array($row) ? $row : [];
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
