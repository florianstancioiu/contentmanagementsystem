<?php

namespace Common\Models;

use Common\Model;

class Post extends Model
{
    public static $table = 'posts';

    public static $columns = [
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
