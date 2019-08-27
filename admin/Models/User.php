<?php

namespace Admin\Models;

use Common\Model;
use \PDOException;

class User extends Model
{
    public static $table = 'users';

    public static $columns = [
        'id', 'first_name', 'last_name', 'email', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected static function signin()
    {
        $statement = self::$pdo->prepare('SELECT id, first_name, last_name, email, password, created_at from users where email = :email');
        
        try {
            $statement->execute([
                ':email' => post('email')
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        $data = $statement->fetchObject();
        $array_data = get_object_vars($data);

        // verify password hash
        if (password_verify(post('password'), $array_data['password'])) {
            $_SESSION['is_logged'] = true;
            $_SESSION['user'] = $array_data;
        }

        // redirect to admin area
        if (is_logged_in()) {
            redirect('/admin');
        }

        redirect('/signin', [
            'message' => "The credentials don't match"
        ]);
    }

    public static function emailExistsInDatabase() : bool
    {
        // check email address existence in database
        $statement = self::$pdo->prepare('SELECT first_name, email from users where email = :email');

        try {
            $statement->execute([
                ':email' => post('email')
            ]);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        $data = $statement->fetchObject();

        return (bool) $data->email === post('email');
    }

    public static function signup()
    {
        if (self::$pdo->emailExistsInDatabase()) {
            redirect('/register', [
                'message' => 'The email address you typed-in exists in database'
            ]);
        }

        // validate the variables
        $data = [
            ':first_name' => post('first_name'),
            ':last_name' => post('last_name'),
            ':email' => post('email'),
            ':password' => password_hash(post('password'), PASSWORD_BCRYPT)
        ];

        try {
            $statement = self::$pdo->prepare('INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (:first_name, :last_name, :email, :password, NOW())');
            $statement->execute($data);
        } catch (PDOException $error) {
            dd($error->getMessage());
        }

        redirect('/admin');
    }
}