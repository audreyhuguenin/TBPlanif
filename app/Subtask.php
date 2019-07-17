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

/**
 * Permet de récupérer toutes les tâches existantes pour cette sous taches
 */
    public function tasks()
    {
        return $this->hasMany('App\Task', 'subtask_id', 'project_id');
    }

    /**
     * Permet de récupérer le projet auquel appartient la sous tâche.
     */
       public function project()
{
    return $this->belongsTo('App\Project', 'project_id', 'number');
}
}

