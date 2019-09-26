<?php

namespace App\DbLayers;

use Common\DbLayer;

class Drink extends DbLayer
{
    protected static $table = 'drinks';

    protected static $searchColumns = [
        'title',
        'slug'
    ];

    protected static $columns = [
        'id',
        'title',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
