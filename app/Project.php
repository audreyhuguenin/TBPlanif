<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Project extends Model
{
    use Sortable;

     protected $table = 'projects';
     protected $fillable = [
        'number',
        'name',
         'fullName',
         'customer'
    ];

    public $sortable = ['number', 'name', 'fullName', 'customer'];

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
