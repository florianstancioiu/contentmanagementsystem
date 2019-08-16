<?php

namespace Admin\Models;

use Common\Model;
use \PDO;

class Post extends Model
{
    public static $table = 'posts';

    public static $columns = [
        'id', 'title', 'slug', 'lang', 'content', 'description', 'user_id', 'created_at'
    ];
}