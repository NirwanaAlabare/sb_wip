<?php

namespace App\Models;

use Illuminate\Foundation\Auth\Line as Authenticatable;

class Line extends Authenticatable
{
    protected $connection = 'mysql_sb_wip';

    protected $table = 'lines';

    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
