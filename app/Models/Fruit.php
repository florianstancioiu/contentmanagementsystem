<?php

namespace App\Models;

use Common\Model;

class Fruit extends Model
{
    protected static $table = 'fruits';

    protected static $searchColumns = [
        'title',
        'slug'
    ];

    protected static $columns = [
        'id',
        'title',
        'slug',
        'image',
        /*
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
        */
    ];
}
