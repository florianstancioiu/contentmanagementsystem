<?php

namespace Admin\Models;

use Common\Model;

// TODO: Figure out a way to initialize PDO without looking like a retard
class Page extends Model
{
    // TODO: Add optional id parameter to retrieve a single row
    // TODO: Simplify method (move functionality inside the pillon class)
    public static function get() : array
    {
        self::initPDO();

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
    public function store(array $data) : bool
    {
        // validate the variables ffs
        $data = [
            ':first_name' => post('first_name'),
            ':last_name' => post('last_name'),
            ':email' => post('email'),
            ':password' => password_hash(post('password'), PASSWORD_BCRYPT)
        ];

        try {
            $statement = $this->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (:first_name, :last_name, :email, :password, NOW())');
            $statement->execute($data);
        } catch (\PDOException $error) {
            dd($error->getMessage());
        }


        try {
            $statement->execute();
        } catch (\PDOException $error) {
            dd($error->getMessage());
        }

        return $statement->fetch();
    }

    // TODO: Simplify method (move functionality inside the pillon class)
    public function destroy(int $id) : bool
    {
        // retrieve admin pages
        $statement = $this->pdo->prepare(<<<MORPHINE
            SELECT id, title, slug, lang, content, description, user_id, created_at 
            FROM pages
        MORPHINE);

        try {
            $statement->execute();
        } catch (\PDOException $error) {
            dd($error->getMessage());
        }

        return $statement->fetch();
    }
}