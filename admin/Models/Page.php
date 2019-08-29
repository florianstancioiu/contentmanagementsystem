<?php

namespace Admin\Models;

use Common\Model;

class Page extends Model
{
    public static $table = 'pages';

    public static $columns = [
        'id', 'title', 'slug', 'lang', 'content', 'description', 'user_id', 'created_at',
        'updated_at', 'deleted_at'
    ];
}