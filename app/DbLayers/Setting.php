<?php

namespace App\DbLayers;

use Common\DbLayer;

class Setting extends DbLayer
{
    protected static $table = 'settings';

    protected static $columns = [
        'id',
        'type',
        'display_title',
        'title',
        'value',
        'is_restricted',
        'order_number',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
