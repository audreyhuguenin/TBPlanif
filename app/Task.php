<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Task extends Model
{
    use Sortable;
      protected $table = 'tasks';

    public $timestamps = false;

    public $sortable = ['name'];

      public function projectSortable($query, $direction)
    {
        return $query->join('subtasks', 'tasks.subtask_id', '=', 'subtasks.project_id')
                        ->orderBy('subtasks.project_id', $direction)
                        ->select('tasks.*')
                        ->groupBy('tasks.id');
    }
 

    /* public function userSortable($query, $direction)
    {
        return $query->join('assignations', 'assignations.task_id', '=', 'tasks.id')
                     ->join('users', 'users.id', '=', 'assignations.user_id')
                        ->orderBy('users.name', $direction)
                        ->select('tasks.*') 
                        ->groupBy('assignations.user_id');
    } */

    public function assignations()
    {
        return $this->hasMany('App\Assignation');
    }

    public function subtask()
{
    return $this->belongsTo('App\Subtask', 'subtask_id', 'id');
}

}
