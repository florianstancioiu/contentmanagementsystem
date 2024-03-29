<?php

namespace App\Models;

use Common\Model;

class Tree extends Model
{
    protected static $table = 'trees';

    protected static $searchColumns = [
        'title',
        'slug'
    ];

    protected static $columns = [
        'id',
        'title',
        'slug',
        'image',
        'has_fruits',
        'fruit_title',
        'colour',
        'growth_location',
        'ripe_season',
        'average_years',
        'average_height',
        'average_width',
        'has_flowers',
        'introduction',
        'description',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
