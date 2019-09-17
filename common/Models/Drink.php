<?php

namespace Common\Models;

use Common\Model;

class Drink extends Model
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
