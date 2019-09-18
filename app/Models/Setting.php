<?php

namespace App\Models;

use Common\Model;

class Setting extends Model
{
    protected static $table = 'settings';

    protected static $columns = [
        'id',
        'type',
        'display_title',
        'title',
        'value',
        'is_restricted',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
