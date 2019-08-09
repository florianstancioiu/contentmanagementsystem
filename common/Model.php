<?php

namespace Common;

use Common\Database;

class Model
{
    protected static $pdo = null;

    protected static function initPDO()
    {
        if (is_null(self::$pdo)) {
            self::$pdo = (new \Common\Database())->pdo;
        }
    }

    public static function __callStatic(string $title, $params)
    {
        self::initPDO();

        if (method_exists(__CLASS__, $title)) {
            static::$title(... $params);
        }
    }
}