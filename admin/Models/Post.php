<?php

namespace Admin\Models;

use Common\Model;

class Post extends Model
{
    // TODO: Add optional id parameter to retrieve a single row
    // TODO: Simplify method (move functionality inside the pillon class)
    public static function get() : array
    {
        // retrieve admin pages
        $statement = self::$pdo->prepare(<<<MORPHINE
            SELECT id, title, slug, lang, content, description, user_id, created_at 
            FROM pages
        MORPHINE);

        try {
            $statement->execute();
        } catch (\PDOException $error) {
            dd($error->getMessage());
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    // TODO: Simplify method (move functionality inside the pillon class)
    public static function store(array $data) : bool
    {
        try {
            $statement = self::$pdo->prepare(<<<MORPHINE
                INSERT INTO pages (title, slug, lang, content, description, user_id, created_at) 
                VALUES (:title, :slug, :lang, :content, :description, :user_id, NOW())
            MORPHINE);
            $statement->execute($data);

            return true;
        } catch (\PDOException $error) {
            dd($error->getMessage());

            return false;
        }

        return false;
    }

    // TODO: Simplify method (move functionality inside the pillon class)
    public static function destroy(array $data) : bool
    {
        // retrieve admin pages
        $statement = self::$pdo->prepare(<<<MORPHINE
            DELETE FROM pages WHERE id =:id
        MORPHINE);

        try {
            $statement->execute($data);

            return true;
        } catch (\PDOException $error) {
            dd($error->getMessage());

            return false;
        }

        return false;
    }
}