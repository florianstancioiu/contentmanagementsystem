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

        $statement = self::$pdo->prepare(<<<MORPHINE
            SELECT $columns_string 
            FROM $table
        MORPHINE);

        try {
            $statement->execute();
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function update(int $id, array $data = []) : bool
    {
        $array_keys = array_keys($data);
        $array_values = array_values($data);

        $array_keys_string = implode(', ', $array_keys);
        $array_values_string = implode(', ', $array_values);

        $table = static::$table;
        $data[':id'] = $data[$id];

        $statement = self::$pdo->prepare(<<<MORPHINE
            UPDATE ($array_keys_string) VALUES ($array_values_string)
            FROM $table
            WHERE id=:id
        MORPHINE);

        try {
            $statement->execute();
        } catch (PDOException $error) {
            dd($error->getMessage());
        }
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

        $statement = self::$pdo->prepare(<<<MORPHINE
            SELECT $columns_string 
            FROM $table
            WHERE id = :id
        MORPHINE);

        try {
            $statement->execute([
                ':id' => $id
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function store(array $data) : bool
    {
        try {
            $statement = self::$pdo->prepare(<<<MORPHINE
                INSERT INTO pages (title, slug, lang, content, description, user_id, created_at) 
                VALUES (:title, :slug, :lang, :content, :description, :user_id, NOW())
            MORPHINE);
            $statement->execute($data);

            return true;
        } catch (PDOException $error) {
            dd($error->getMessage());

            return false;
        }

        return false;
    }

    // TODO: Simplify method (move functionality inside the pylon class)
    public static function destroy(array $data) : bool
    {
        $statement = self::$pdo->prepare(<<<MORPHINE
            DELETE FROM pages WHERE id = :id
        MORPHINE);

        try {
            $statement->execute($data);

            return true;
        } catch (PDOException $error) {
            dd($error->getMessage());

            return false;
        }

        return false;
    }
}