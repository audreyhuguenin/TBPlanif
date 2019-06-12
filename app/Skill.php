<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
   protected $table = 'skills';

    public $timestamps = false;
    
    public function users()
{
    return $this->belongsToMany('App\User', 'skill_user');
}
}
