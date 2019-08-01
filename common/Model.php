<?php

namespace Common;

use Database;

class Model
{
    public $pdo = null;

    public function __construct()
    {
        // initialize the database
        $this->pdo = (new Database())->pdo;
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}