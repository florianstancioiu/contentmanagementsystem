<?php

namespace Admin\Models;

use Common\Model;

class Tree extends Model
{
    public static $table = 'trees';

    public static $columns = [
        'id',
        'title',
        'picture',
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
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}