<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Assignation extends Model
{
    use Sortable;
 protected $table = 'assignations';

  protected $fillable = [
      'date',
      'duration',
      'type',
      'suiviDA',
      'unmovable'
    ];

    public $sortable = ['date', 'duration', 'type'];

    protected $casts = [
        'date' => 'datetime',
        'type' => 'array',
        
    ];

    public $timestamps = false;

    //peut être à utiliser pour mettre en place le tri des projets
    /* public function projectSortable($query, $direction)
    {
        return $query->join('tasks', 'assignations.task_id', '=', 'tasks.id')
                        ->join('subtasks', 'tasks.subtask_id', '=', 'subtasks.project_id')
                        ->orderBy('subtasks.project_id', $direction)
                        ->select('assignations.*')
                        ->groupBy('assignations.id');
    } */
 

    /**
     * permet de récupérer l'utilisateur lié à l'objet assignation
     */

public function user()
{
    return $this->belongsTo('App\User');
}

/**
     * permet de récupérer la tâche à laquelle est liée l'assignation
     */

public function task()
{
    return $this->belongsTo('App\Task');
}

}
