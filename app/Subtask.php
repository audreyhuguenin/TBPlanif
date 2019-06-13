<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
         protected $table = 'subtasks';

         protected $fillable = [
        'name', 'project_id'
    ];

    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

       public function project()
{
    return $this->belongsTo('App\Project', 'project_id', 'number');
}
}

