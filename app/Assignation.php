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
    ];

    public $timestamps = false;

    public function projectSortable($query, $direction)
    {
        return $query->join('tasks', 'assignations.task_id', '=', 'tasks.id')
                        ->join('subtasks', 'tasks.subtask_id', '=', 'subtasks.project_id')
                        ->join('projects', 'subtasks.project_id', '=', 'projects.number')
                        ->orderBy('fullName', $direction)
                        ->select('assignations.*');
    }
public function user()
{
    return $this->belongsTo('App\User');
}

public function task()
{
    return $this->belongsTo('App\Task');
}

}
