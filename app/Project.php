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

    /* public function projectSortable($query, $direction)
    {
        return $query->orderBy('fullName', $direction)
                    ->select('projects.*');
    } */

    public $timestamps = false;

    /**
     * Permet de récupérer toutes les sous taches du projet visé
     */
    public function subtasks()
    {
        return $this->hasMany('App\Subtask', 'project_id', 'number');
    }


    /**
     * Permet de récupérer tous les plannings contenant le projet
     */
    public function plannings()
{
    return $this->belongsToMany('App\Planning', 'planning_project', 'number', 'planning_id');
}

}
