<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
   protected $table = 'skills';

    public $timestamps = false;

    /**
     * Permet de récupérer tous les utilisateurs qui ont cette compétence
     */
    public function users()
{
    return $this->belongsToMany('App\User', 'skill_user');
}
}
