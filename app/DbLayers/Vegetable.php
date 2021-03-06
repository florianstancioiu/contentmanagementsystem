<?php

namespace App\DbLayers;

use Common\DbLayer;

class Vegetable extends DbLayer
{
    protected static $table = 'vegetables';

    protected static $searchColumns = [
        'title',
        'slug'
    ];

    protected static $columns = [
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
