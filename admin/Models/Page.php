<?php

namespace Admin\Models;

use Common\Model;

class Page extends Model
{
    public static $table = 'pages';

    public static $columns = [
        'id', 'title', 'slug', 'lang', 'content', 'description', 'user_id', 'created_at'
    ];


    // TODO: Simplify method (move functionality inside the pillon class)
    public static function store(array $data) : bool
    {
        self::initPDO();

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
        self::initPDO();

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