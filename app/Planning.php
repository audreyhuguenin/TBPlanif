<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
 protected $table = 'plannings';
 protected $fillable = [
        'sent', 'weeknumber'
    ];

    public $timestamps = false;
    /**
     * Permet de récupérer l'utilisateur lié au planning (l'AM qui l'a créé)
     */

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Permet de récupérer les projets liés au planning
     */
    public function projects()
    {
        return $this->belongsToMany('App\Project', 'planning_project', 'planning_id', 'number');
    }

    /**
     * Permet de récupérer le planning parent s'il y en existe un
     */
    public function globalPlanning()
    {
        return $this->belongsTo('App\Planning', 'parent_id');
    }

    /**
     * Permet de récupérer les plannings enfants si le planning choisi est un planning global
     */
    public function children()
    {
        return $this->hasMany('App\Planning', 'parent_id');
    }

}
