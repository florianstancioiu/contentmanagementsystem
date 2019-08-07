<?php

namespace Common;

use Common\Database;

class Model
{
    protected static $pdo = null;

    protected static function initPDO()
    {
        self::$pdo = (new Database())->pdo;
    }
}