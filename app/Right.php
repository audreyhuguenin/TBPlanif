<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'method', 'routename', 'level'
    ];

}
