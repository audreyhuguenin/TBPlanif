<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
         protected $table = 'subtasks';

         protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
