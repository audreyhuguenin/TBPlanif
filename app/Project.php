<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $table = 'projects';
     protected $fillable = [
        'number',
        'name',
         'fullName',
         'customer'
    ];

    public $timestamps = false;

    public function subtasks()
    {
        return $this->hasMany('App\Subtask', 'project_id', 'number');
    }

    public function plannings()
{
    return $this->belongsToMany('App\Planning', 'planning_project', 'number', 'planning_id');
}

}
