<?php

namespace App\DbLayers;

use Common\DbLayer;

class Page extends DbLayer
{
    protected static $table = 'pages';

    protected static $searchColumns = [
        'title',
        'slug'
    ];

    protected static $columns = [
        'id',
        'title',
        'slug',
        'lang',
        'content',
        'description',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
