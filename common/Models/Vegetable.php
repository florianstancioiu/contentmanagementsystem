<?php

namespace Common\Models;

use Common\Model;

class Vegetable extends Model
{
    public static $table = 'vegetables';

    public static $columns = [
        'id',
        'title',
        'slug',
        'image',
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
