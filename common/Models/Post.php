<?php

namespace Common\Models;

use Common\Model;

class Post extends Model
{
    protected static $table = 'posts';

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
